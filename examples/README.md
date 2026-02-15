# Examples

All example scripts expect the API to be running at `http://127.0.0.1:5000`.

## Optional API key

If your API requires a key, set it in the environment before running examples:

```bash
export INTERNAL_API_KEY="your-key-here"
```

The examples will read `INTERNAL_API_KEY` if set.

## Run an example

```bash
php examples/resume_parse.php
```

## Available examples

- `resume_extract_url.php`
- `resume_extract_path.php`
- `resume_parse.php`
- `resume_parse_batch.php`
- `job_generate.php`
- `jobs_score.php`
- `candidates_score.php`
