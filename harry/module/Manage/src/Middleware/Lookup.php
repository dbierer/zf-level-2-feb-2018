<?php
namespace Manage\Middleware;

use PDO;
//*** add the proper "use" statements

class Lookup implements MiddlewareInterface
{
    use TableTrait;
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data = [];
        foreach ($this->table->select() as $obj) {
            $data[] = [$obj->email, $obj->provider];
        }
        $results = json_encode(['data' => $data]);
        //*** formulate a PSR-7 compliant response; hint: zend-diactoros
        //*** write the results to the "body"
        //*** return the response, but don't forget to set the header!
        return ???;
    }
}
