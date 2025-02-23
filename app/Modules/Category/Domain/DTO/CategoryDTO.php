<?

namespace App\Modules\Category\Domain\DTO;

use Illuminate\Http\Request;

class CategoryDTO
{
    private string $name;

    public function setName(string $name) 
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function fromCreateRequest(Request $request)
    {
        $categoryDTO = new self();

        $categoryDTO->setName($request->name);

        return $categoryDTO;
    }

    /**
     * Return attributes as an array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}