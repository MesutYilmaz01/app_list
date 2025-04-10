<?

namespace App\Modules\Authority\Domain\DTO;

class AuthorityDTO
{
    private string $name;
    private string $code;

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCode(int $code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public static function fromCreateRequest(array $request)
    {
        $authorityDTO = new self();

        $authorityDTO->setName($request["name"]);
        $authorityDTO->setName($request["code"]);

        return $authorityDTO;
    }

    public static function fromUpdateRequest(array $request)
    {
        $authorityDTO = new self();

        if (isset($request["name"]))
            $authorityDTO->setName($request["name"]);
        if (isset($request["code"]))
            $authorityDTO->setCode($request["code"]);

        return $authorityDTO;
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
