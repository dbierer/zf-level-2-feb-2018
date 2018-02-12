<?php
namespace DefaultLocale\Middleware;

use Locale;
//*** add the appropriate "use" statements

class Browser
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        //*** get the Accept-Language header from $request
        $acceptLangHeader = '???';
        if (empty($acceptLangHeader)) {
            return FALSE;
        }
        $accepted = [];
        $tempList = explode(',', $acceptLangHeader);
        foreach ($tempList as $item) {
            if (strpos($item, ';')) {
                list($locale, $quality) = explode(';', strip_tags($item));
            } elseif (strpos($item, '-')) {
                list($locale, $region) = explode('-', strip_tags($item));
            } else {
                $locale = $item;
            }
            $locale = trim($locale);
            if ($locale !== 'null') $accepted[] = $locale;
        }
        if ($accepted) Locale::setDefault($accepted[0] ?? $accepted[1] ?? $accepted[2]);
    }
}
