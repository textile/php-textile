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

    // Live Textile editor.

    require(['jquery'], function ($)
    {
        var form = $('form.sandbox'), htmlview = $('<div class="view html" />'), preview = $('<div class="view preview" />');

        form.on('submit', function (e)
        {
            var $this = $(this).addClass('busy');
            e.preventDefault();
            $this.find('.view, .alert').remove();

            $.ajax($this.attr('action'), {
                data: $this.serialize()
            })
                .done(function (data)
                {
                    if ($.type(data.error) === 'object')
                    {
                        $this.prepend($('<p class="alert error" />').text(data.error.message));
                    }

                    if ($.type(data.output) === 'string')
                    {
                        $this.append(htmlview.text(data.output)).append(preview.html(data.output));
                    }
                })
                .always(function ()
                {
                    $this.removeClass('busy');
                })
                .fail(function ()
                {
                    window.alert('Error occurred. Please try again later.');
                });
        });
    });
})();
