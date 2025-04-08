<?php
header('Content-Type: application/json');

// Load .env zonder Composer
function loadEnv($path) {
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0 || !str_contains($line, '=')) continue;

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, "\"' "); // Verwijder quotes en spaties

        putenv("$name=$value");
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

// .env laden
loadEnv(__DIR__ . '/../../.env');

// 🗝️ Haal API key op
$apiKey = $_ENV['APIKEY'] ?? null;
if (!$apiKey) {
    echo json_encode(['message' => 'API key niet gevonden in .env']);
    exit;
}

// 📥 Bericht binnenhalen
$input = json_decode(file_get_contents('php://input'), true);
$message = trim($input['message'] ?? '');

if (empty($message)) {
    echo json_encode(['message' => 'Geen bericht ontvangen.']);
    exit;
}

// 🔗 Hugging Face API instellingen
$model = 'mistralai/Mistral-7B-Instruct-v0.1';
$url = "https://api-inference.huggingface.co/models/{$model}";

// ✍️ Prompt bouwen
$prompt = <<<EOT
Je bent een professionele Nederlandstalige AI-assistent voor de website van een apotheek genaamd Apothecare. Je spreekt altijd beleefd, duidelijk en klantgericht. Je bent getraind om klanten te helpen met vragen over medicijnen, bijsluiters, openingstijden, herhaalrecepten, bijwerkingen, leveringen en algemene gezondheidsadviezen.

Spreek altijd in correct en verzorgd Nederlands, gebruik een vriendelijke en betrouwbare toon, zoals een ervaren apothekersassistent zou doen.

Belangrijke regels voor je gedrag:

Geef nooit medisch advies dat een arts moet geven; verwijs klanten in dat geval altijd vriendelijk door naar hun huisarts.

Wees discreet en respectvol over gezondheidsinformatie.

Geef duidelijke en praktische informatie, zonder overbodige details.

Wees geduldig, ook als de klant weinig kennis van medicijnen heeft.

Gebruik waar nodig voorbeelden, maar houd het professioneel.

Noem jezelf "de digitale assistent van Apothecare" wanneer je jezelf moet voorstellen.

Voorbeeldvragen die je kunt beantwoorden:

"Hoe werkt ibuprofen?"

"Wat zijn jullie openingstijden op feestdagen?"

"Hoe vraag ik een herhaalrecept aan bij jullie?"

"Mijn medicatie is niet geleverd, wat moet ik doen?"

Blijf altijd binnen je rol als apotheek-assistent. Gebruik geen slang of informeel taalgebruik.

Klant: {$message}
ApotheCare:
EOT;

$data = [
    "inputs" => $prompt,
    "parameters" => [
        "temperature" => 0.5,
        "max_new_tokens" => 150,
        "stop" => ["Klant:"]
    ]
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer $apiKey\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
        'timeout' => 10
    ]
];

$context = stream_context_create($options);
$response_raw = file_get_contents($url, false, $context);

if ($response_raw === false) {
    echo json_encode(['message' => 'Er ging iets mis bij het ophalen van een AI-response.']);
    exit;
}

$response_data = json_decode($response_raw, true);
$generated_text = $response_data[0]['generated_text'] ?? 'Geen bruikbaar antwoord ontvangen.';

// 🔍 Schoonmaken
$cleaned = str_replace($prompt, '', $generated_text);

// 🚫 Inhoudsfilter
if (stripos($cleaned, 'nigger') !== false || stripos($cleaned, 'sikte') !== false) {
    $cleaned = 'Excuses, er ging iets mis bij het genereren van een passend antwoord.';
}

// 📤 Output
echo json_encode(['message' => trim($cleaned)]);
