/*!
 * Documenter 2.0
 * http://rxa.li/documenter
 *
 * Copyright 2011, Xaver Birsak
 * http://revaxarts.com
 *
 */

$(document).ready(function () {
    var timeout,
        sections = new Array(),
        sectionscount = 0,
        win = $(window),
        sidebar = $('#documenter_sidebar'),
        nav = $('#documenter_nav'),
        logo = $('#documenter_logo'),
        navanchors = nav.find('a'),
        timeoffset = 50,
        hash = location.hash || null;
    iDeviceNotOS4 = (navigator.userAgent.match(/iphone|ipod|ipad/i) && !navigator.userAgent.match(/OS 5/i)) || false,
        badIE = $('html').prop('class').match(/ie(6|7|8)/) || false;

    //handle external links (new window)
    $('a[href^=http]').bind('click', function () {
        window.open($(this).attr('href'));
        return false;
    });

    //IE 8 and lower doesn't like the smooth pagescroll
    if (!badIE) {
        window.scroll(0, 0);

        $('a[href^=#]').bind('click touchstart', function () {
            hash = $(this).attr('href');
            $.scrollTo.window().queue([]).stop();
            goTo(hash);
            return false;
        });

        //if a hash is set => go to it
        if (hash) {
            setTimeout(function () {
                goTo(hash);
            }, 500);
        }
    }


    //We need the position of each section until the full page with all images is loaded
    win.bind('load', function () {

        var sectionselector = 'section';

        //Documentation has subcategories
        if (nav.find('ol').length) {
            sectionselector = 'section, h4';
        }
        //saving some information
        $(sectionselector).each(function (i, e) {
            var _this = $(this);
            var p = {
                id:this.id,
                pos:_this.offset().top
            };
            sections.push(p);
        });


        //iPhone, iPod and iPad don't trigger the scroll event
        if (iDeviceNotOS4) {
            nav.find('a').bind('click', function () {
                setTimeout(function () {
                    win.trigger('scroll');
                }, duration);

            });
            //scroll to top
            window.scroll(0, 0);
        }

        //how many sections
        sectionscount = sections.length;

        //bind the handler to the scroll event
        win.bind('scroll',function (event) {
            clearInterval(timeout);
            //should occur with a delay
            timeout = setTimeout(function () {
                //get the position from the very top in all browsers
                pos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;

                //iDeviceNotOS4s don't know the fixed property so we fake it
                if (iDeviceNotOS4) {
                    sidebar.css({height:document.height});
                    logo.css({'margin-top':pos});
                }
                //activate Nav element at the current position
                activateNav(pos);
            }, timeoffset);
        }).trigger('scroll');

    });

    //the function is called when the hash changes
    function hashchange() {
        goTo(location.hash, false);
    }

    //scroll to a section and set the hash
    function goTo(hash, changehash) {
        win.unbind('hashchange', hashchange);
        hash = hash.replace(/!\//, '');
        win.stop().scrollTo(hash, duration, {
            easing:easing,
            axis:'y'
        });
        if (changehash !== false) {
            var l = location;
            location.href = (l.protocol + '//' + l.host + l.pathname + '#!/' + hash.substr(1));
        }
        win.bind('hashchange', hashchange);
    }


    //activate current nav element
    function activateNav(pos) {
        var offset = 100,
            current, next, parent, isSub, hasSub;
        win.unbind('hashchange', hashchange);
        for (var i = sectionscount; i > 0; i--) {
            if (sections[i - 1].pos <= pos + offset) {
                navanchors.removeClass('current');
                current = navanchors.eq(i - 1);
                current.addClass('current');

                parent = current.parent().parent();
                next = current.next();

                hasSub = next.is('ul');
                isSub = !parent.is('#documenter_nav');

                nav.find('ol:visible').not(parent).slideUp('fast');
                if (isSub) {
                    parent.prev().addClass('current');
                    parent.stop().slideDown('fast');
                } else if (hasSub) {
                    next.stop().slideDown('fast');
                }
                win.bind('hashchange', hashchange);
                break;
            }
            ;
        }
    }

    // make code pretty
    window.prettyPrint && prettyPrint();

});

/* demo example scripts */
$(function () {
    $("#button1").click(function () {
        $("#dialog1").dockmodal();
        return false;
    });
    $("#button2").click(function () {
        $("#dialog2").dockmodal({
            initialState:"docked"
        });
        return false;
    });
    $("#button3").click(function () {
        $("#dialog3").dockmodal({
            initialState:"minimized"
        });
        return false;
    });

    $("#button4").click(function () {
        $("#dialog4").dockmodal({
            initialState:"docked",
            width:300,
            minimizedWidth:200,
            height:"40%",
            title:"Custom dimension 1"
        });
        return false;
    });

    $("#button5").click(function () {
        $("#dialog5").dockmodal({
            initialState:"docked",
            width:500,
            minimizedWidth:300,
            height:"50%",
            title:"Custom dimension 2"
        });
        return false;
    });

    $("#button6").click(function () {
        $("#dialog6").dockmodal({
            initialState:"modal",
            title:"Modal - close only",
            showClose:true,
            showPopout:false,
            showMinimize:false
        });
        return false;
    });

    $("#button7").click(function () {
        $("#dialog7").dockmodal({
            initialState:"docked",
            title:"Docked - close only",
            showClose:true,
            showPopout:false,
            showMinimize:false
        });
        return false;
    });

    $("#button8").click(function () {
        $("#dialog8").dockmodal({
            title:"Dialog with footer actions",
            initialState:"docked",
            width:400,
            buttons:[
                {
                    html:'Cancel',
                    buttonClass:'btn btn-primary',
                    click:function (e, dialog) {
                        // do something when the button is clicked
                        dialog.dockmodal("close");
                    }
                },
                {
                    html:'Ok',
                    buttonClass:'btn btn-primary',
                    click:function (e, dialog) {
                        // do something when the button is clicked
                        dialog.dockmodal("close");
                    }
                }
            ]
        });
        return false;
    });

    $("#button9").click(function () {
        $.get("ajax-content.txt", function (data) {
            $("<div/>").html(data).dockmodal({
                initialState:"docked",
                title:"Ajax content",
                width:300,
                buttons:[
                    {
                        html:'Cancel',
                        buttonClass:'btn btn-primary',
                        click:function (e, dialog) {
                            // do something when the button is clicked
                            dialog.dockmodal("close");
                        }
                    },
                    {
                        html:'Ok',
                        buttonClass:'btn btn-primary',
                        click:function (e, dialog) {
                            // do something when the button is clicked
                            dialog.dockmodal("close");
                        }
                    }
                ]
            });
        });
        return false;
    });

    $("#button10").click(function () {
        $("#dialog10").dockmodal({
            title:"Modal with events",
            initialState:"docked",
            width:400,
            open:function (event, dialog) {
                alert("Dialog opened");
            },
            minimize:function (event, dialog) {
                alert("Dialog minimized");
            },
            close:function (event, dialog) {
                alert("Dialog closed");
            }
        });
        return false;
    });
});