<?

namespace App\Modules\ArtificialIntelligence\Infrastructure\ThirdParty;

use App\Modules\ArtificialIntelligence\Domain\Interfaces\IArtificialIntelligence;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class Gemini implements IArtificialIntelligence
{
    private string $url = "";
    private string $apiKey = "";

    public function __construct()
    {
        $this->url = env("GEMINI_BASE_URL");
        $this->apiKey = env("GEMINI_API_KEY");
    }

    /**
     * Communicates with gemini according to given prompt and returns answer as json.
     * 
     * @param array $parameters
     * @return JsonResponse
     */
    public function communicate(array $parameters): JsonResponse
    {
        $date = $parameters["date"];
        $type = $parameters["type"];
        $count = $parameters["count"];
        $category = $parameters["category"];
        $subject = $parameters["subject"];

        $userListRequest = "{$date} {$type} {$count} {$category} {$subject} listeler misin?. Bu listeyle ilgili header keyi ile bir başlık ve description keyi ile bir açıklama yaz. Önerdiğin liste elemanları için de birer başlık ve açıklama yaz ve bunları header ve description keyi ile yaz. Bunu list keyine ata. Cevaba başka bir şey ekleme ve json olarak ver.";
        $response = Http::post(
            $this->url . $this->apiKey,
            [
                "contents" => [
                    "parts" => [
                        "text" => $userListRequest
                    ]
                ]
            ]
        );

        $answer = $response->json()["candidates"][0]["content"]["parts"][0]["text"];
        $array = explode("json", $answer);
        return response()->json(
            json_decode(substr($array[1], 0, -3), true)
        );
    }
}
