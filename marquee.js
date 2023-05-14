(function(jQuery) {
    jQuery.fn.textWidth = function(){
         var calc = '<span style="display:none">' + jQuery(this).text() + '</span>';
         jQuery('.pengumuman').append(calc);
         var width = jQuery('.pengumuman').find('span:last').width();
         jQuery('.pengumuman').find('span:last').remove();
        return width;
    };
    
    jQuery.fn.marquee = function(args) {
        var that = jQuery(this);
        var textWidth = that.textWidth(),
            // offset = that.width(),
            offset = jQuery(".running-text-footer").width(),
            width = offset,
            css = {
                'text-indent' : that.css('text-indent'),
                'overflow' : that.css('overflow'),
                'white-space' : that.css('white-space')
            },
            marqueeCss = {
                'text-indent' : width,
                'overflow' : 'hidden',
                'white-space' : 'nowrap'
            },
            args = jQuery.extend(true, { count: -1, speed: 1e1, leftToRight: false }, args),
            i = 0,
            stop = textWidth*-1,
            dfd = jQuery.Deferred();

            // console.log(jQuery(".running-text-footer").width());

        function go_pengumuman() {
            if(!that.length) return dfd.reject();
            if(width <= stop) {
                i++;
                if(i == args.count) {
                    that.css(css);
                    return dfd.resolve();
                }
                if(args.leftToRight) {
                    width = textWidth*-1;
                } else {
                    width = offset;
                }
            }
            that.css('text-indent', width + 'px');
            if(args.leftToRight) {
                width++;
            } else {
                width--;
            }
            setTimeout(go_pengumuman, args.speed);
        };
        if(args.leftToRight) {
            width = textWidth*-1;
            width++;
            stop = offset;
        } else {
            width--;            
        }
        that.css(marqueeCss);
        go_pengumuman();
        return dfd.promise();
    };
})(jQuery);