<?php
declare(strict_types=1);

/**
 * Cliente mínimo para la API de dLocal Go (v1).
 * Docs: https://docs.dlocalgo.com  — verificá los campos en sandbox antes de pasar a 'live'.
 *
 * Flujo: createPayment() devuelve redirect_url -> el cliente paga en el checkout de dLocal Go
 * (tarjeta y medios locales de su país) -> vuelve a success_url / back_url
 * -> dLocal Go avisa a notification_url (webhook.php) con el payment_id.
 */
final class DlocalGo
{
    private string $baseUrl;

    public function __construct(
        private string $apiKey,
        private string $secretKey,
        string $env = 'sandbox'
    ) {
        $this->baseUrl = $env === 'live'
            ? 'https://api.dlocalgo.com'
            : 'https://api-sbx.dlocalgo.com';
    }

    /**
     * @param array $data amount, currency, order_id, description, success_url, back_url, notification_url
     *                    (country es opcional: si no se manda, el cliente lo elige en el checkout)
     * @return array respuesta de dLocal Go (incluye 'id', 'status', 'redirect_url')
     */
    public function createPayment(array $data): array
    {
        return $this->request('POST', '/v1/payments', $data);
    }

    public function getPayment(string $paymentId): array
    {
        return $this->request('GET', '/v1/payments/' . rawurlencode($paymentId));
    }

    private function request(string $method, string $path, ?array $body = null): array
    {
        $ch = curl_init($this->baseUrl . $path);
        $headers = [
            'Authorization: Bearer ' . $this->apiKey . ':' . $this->secretKey,
            'Content-Type: application/json',
            'Accept: application/json',
        ];
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20,
        ]);
        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
        }
        $raw = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($raw === false) {
            throw new RuntimeException('dLocal Go no respondió: ' . $error);
        }
        $json = json_decode($raw, true);
        if ($status >= 400 || !is_array($json)) {
            throw new RuntimeException('dLocal Go error ' . $status . ': ' . substr((string) $raw, 0, 300));
        }
        return $json;
    }
}
