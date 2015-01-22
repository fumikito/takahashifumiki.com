/**
 * Description
 */

/*global google: true*/

(function ($) {
    'use strict';

    var chart = null,
        resizeTimer = null;

    google.load('visualization', '1.0');
    google.setOnLoadCallback(function(){
        $('.chart-form').submit(function(e) {
            e.preventDefault();
            var $form = $(this);
            if( $form.hasClass('loading') ){
                return;
            }else{
                $form.addClass('loading');
            }
            $form.ajaxSubmit({
                success: function (result) {
                    if (result.success) {
                        // Initialize chart
                        if( !chart ){
                            chart = new google.visualization.ChartWrapper({
                                chartType: result.chart,
                                containerId: 'google-chart'
                            });
                        }
                        chart.setOptions(result.options);
                        chart.setDataTable(result.data);
                        chart.draw();
                        // Push state
                        try{
                            if( document.location !== result.link ){
                                history.pushState('popstate.chart.pushstate', result.title, result.link);
                            }
                        }catch(err){}
                    } else {
                        window.alert('チャートを取得できませんでした。');
                    }
                },
                error: function (xhr, status, message) {
                    window.alert(message);
                },
                complete: function(){
                    $form.removeClass('loading');
                }
            });
        });
        $('.chart-form').submit();
        // レスポンシブにする
        $(window).resize(function(){
            if( resizeTimer ){
                clearTimeout(resizeTimer);
            }
            resizeTimer = setTimeout(function(){
                if( chart ){
                    chart.draw();
                }
            }, 500);
        });
    });

})(jQuery);
