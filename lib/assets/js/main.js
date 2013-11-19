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

    // Select text on click.

    require(['jquery'], function ($)
    {
        $('.selectable, pre').on('click', function (e)
        {
            e.preventDefault();

            var copy, range, selection, $this = $(this), region = $this.find('.selectable-region, code');

            if (!region.length)
            {
                region = $this;
            }

            copy = region.get(0);

            if ($.type(document.selection) !== 'undefined')
            {
                range = document.body.createTextRange();
                range.moveToElementText(copy);
                range.select();
            }
            else if ($.type(window.getSelection) !== 'undefined')
            {
                selection = window.getSelection();
                range = document.createRange();
                range.selectNode(copy);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        });
    });

    // Live Textile editor.

    require(['jquery'], function ($)
    {
        var form = $('form.async'), htmlview = $('<div class="view html" />'), preview = $('<div class="view preview" />');

        form.on('submit', function (e)
        {
            var $this = $(this);
            e.preventDefault();

            require(['spin'], function (Spinner)
            {
                var spinner = new Spinner({
                    length: 5,
                    width: 3,
                    color: '#999',
                    radius: 5,
                    corners: 1
                }).spin($this.find('[type=submit]').get(0));

                $this.addClass('busy');

                $.ajax($this.attr('action'), {
                    data: $this.serialize()
                })
                    .done(function (data)
                    {
                        $this.find('.wrapper, .alert').remove();

                        if ($.type(data.error) === 'object')
                        {
                            $this.prepend($('<p class="alert error" />').text(data.error.message));
                        }

                        if ($.type(data.output.restricted) === 'string')
                        {
                            $this.append($('<div class="wrapper" />').html(htmlview.html($('<pre class="prettyprint language-html" />').html($('<code />').text(data.output.restricted))).prepend('<h2>HTML source</h2>')).append(preview.html(data.output.restricted).prepend('<h2>Preview</h2>')));

                            require(['prettify'], function ()
                            {
                                prettyPrint();
                            });
                        }
                    })
                    .always(function ()
                    {
                        $this.removeClass('busy');
                        spinner.stop();
                    })
                    .fail(function ()
                    {
                        window.alert('Error occurred. Please try again later.');
                    });
            });
        });
    });
})();
