# AVAHR Internal API SDK (PHP)

Minimal PHP SDK for the internal Python API.

## Install

```bash
composer require c-alen/avahr-internal-api
```

## Usage

```php
use Avahr\\InternalApi\\Client;

$client = new Client('http://127.0.0.1:5000', 'YOUR_API_KEY'); // api key optional

// Resume extract
$extracted = $client->resumeExtractFromUrl('https://example.com/resume.pdf');

// Resume parse
$parsed = $client->resumeParse($extracted['plain']);

// Batch parse
$batch = $client->resumeParseBatch([
    'Resume 1 text...',
    'Resume 2 text...'
]);

// Job generate
$job = $client->jobGenerate('Write a senior backend engineer JD...');

// Jobs score
$score = $client->jobsScore(
    ['title' => 'Backend Engineer', 'skills' => ['Python','SQL']],
    ['Experience' => '0-2=low, 3-5=mid, 6+=high', 'Skills' => 'match % of required skills']
);

// Candidate score
$candidate = $client->candidatesScore('Resume text...', 'Job description...');
```

## Examples
See `examples/README.md` for runnable scripts for every endpoint.

## Notes
- Uses `ext-curl`.
- Throws `Avahr\\InternalApi\\Exceptions\\ApiException` on API errors.
