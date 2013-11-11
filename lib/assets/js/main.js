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
        var code = $('pre[class^=language-] code');

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

    // Navigation.

    require(['jquery'], function ($)
    {
        var toggle = $('<div class="menu-toggle"><a href="#"><i class="fa fa-bars"></i></a></div>'), nav = $('nav'), body = $('body');

        body.append(toggle);

        toggle.show().find('a').on('click', function (e)
        {
            e.preventDefault();
            body.toggleClass('menu-opened');
        });

        nav.find('a').click(function ()
        {
            body.removeClass('menu-opened');
        });
    });
})();
