(function ()
{
    'use strict';

    requirejs.config({
        paths:
        {
            'jquery': '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min',
            'webfont' : '//ajax.googleapis.com/ajax/libs/webfont/1.4.10/webfont'
        }
    });

    require(['webfont'], function ()
    {
        WebFont.load({
            google:
            {
                families: ['PT+Sans+Narrow:700:latin', 'Cousine::latin']
            }
        });
    });

    require(['jquery'], function ($)
    {
        var code = $('pre code');

        // Syntax highlighting.

        if (code.length)
        {
            code.parent().addClass('prettyprint');

            require(['prettify'], function ()
            {
                prettyPrint();
            });
        }
    });
})();
