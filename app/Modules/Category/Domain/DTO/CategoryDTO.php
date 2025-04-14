<?

namespace App\Modules\Category\Domain\DTO;

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

    public static function fromCreateRequest(array $request)
    {
        $categoryDTO = new self();

        $categoryDTO->setName($request["name"]);

        return $categoryDTO;
    }

    public static function fromUpdateRequest(array $request)
    {
        $categoryDTO = new self();

        if (isset($request["name"]))
            $categoryDTO->setName($request["name"]);

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
