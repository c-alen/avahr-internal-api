<?php

declare(strict_types=1);

namespace Avahr\InternalApi;

use Avahr\InternalApi\Exceptions\ApiException;

class Client
{
    private string $baseUrl;
    private ?string $apiKey;
    private int $timeout;

    public function __construct(string $baseUrl, ?string $apiKey = null, int $timeout = 60)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;
        $this->timeout = $timeout;
    }

    /**
     * Extract resume text from a URL.
     * @return array{plain:string,html:string}
     */
    public function resumeExtractFromUrl(string $fileUrl): array
    {
        return $this->request('POST', '/ml/resume/extract', [
            'file_url' => $fileUrl,
        ]);
    }

    /**
     * Extract resume text from a local file path on the API server.
     * @return array{plain:string,html:string}
     */
    public function resumeExtractFromPath(string $filePath): array
    {
        return $this->request('POST', '/ml/resume/extract', [
            'file_path' => $filePath,
        ]);
    }

    /**
     * Parse a single resume plain text into schema.
     */
    public function resumeParse(string $plain): array
    {
        return $this->request('POST', '/ml/resume/parse', [
            'plain' => $plain,
        ]);
    }

    /**
     * Parse 1..5 resumes in a batch.
     */
    public function resumeParseBatch(array $plains): array
    {
        return $this->request('POST', '/ml/resume/parse-batch', [
            'plains' => $plains,
        ]);
    }

    /**
     * Generate a job description HTML section.
     */
    public function jobGenerate(string $prompt): array
    {
        return $this->request('POST', '/ml/job/generate', [
            'prompt' => $prompt,
        ]);
    }

    /**
     * Score job data based on criteria.
     */
    public function jobsScore(array $input, array $criteria, ?array $responseSample = null): array
    {
        $payload = [
            'input' => $input,
            'criteria' => $criteria,
        ];
        if ($responseSample !== null) {
            $payload['responseSample'] = $responseSample;
        }

        return $this->request('POST', '/ml/jobs/score', $payload);
    }

    /**
     * Score a candidate resume against a job description.
     */
    public function candidatesScore(string $resumePlain, string $jobDescription): array
    {
        return $this->request('POST', '/ml/candidates/score', [
            'resume_plain' => $resumePlain,
            'job_description' => $jobDescription,
        ]);
    }

    /**
     * Low-level JSON request helper.
     */
    private function request(string $method, string $path, array $payload): array
    {
        $url = $this->baseUrl . $path;

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
        ];
        if ($this->apiKey) {
            $headers[] = 'X-Internal-API-Key: ' . $this->apiKey;
        }

        $ch = curl_init($url);
        if ($ch === false) {
            throw new ApiException('Failed to initialize cURL');
        }

        $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE);
        if ($jsonPayload === false) {
            throw new ApiException('Failed to encode request JSON');
        }

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
        ]);

        $responseBody = curl_exec($ch);
        $curlErr = curl_error($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($responseBody === false) {
            throw new ApiException('Request failed: ' . $curlErr);
        }

        $decoded = json_decode($responseBody, true);
        if (!is_array($decoded)) {
            throw new ApiException('Invalid JSON response', $status, ['raw' => $responseBody]);
        }

        if ($status < 200 || $status >= 300) {
            $message = $decoded['error'] ?? 'API error';
            throw new ApiException($message, $status, $decoded);
        }

        return $decoded;
    }
}
