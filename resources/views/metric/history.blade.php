<x-layout>
    <x-slot:title>
        BROOBE Metric History
        </x-slot>
        <div class="row">
            <div class="text-info w-100 float-left col-md-12">
                <h1 class="text-lightblue">Metric History</h1>
            </div>
        </div>
        <div class="overlay-wrapper">
            <div class="overlay" id="spinner-history" style="display:none">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2" id="text-spinner-history">Loading...</div>
            </div>
            <div class="card card-indigo">
                <div class="card-header border-0">
                    <h3 class="card-title">Metrics</h3>
                    <div class="card-tools">
                        <button type="button" id="sync-button" class="btn btn-tool">
                            <i class="fas fa-sync"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr class="text-center">
                                <th>Url</th>
                                <th>Accesibility</th>
                                <th>Pwa</th>
                                <th>Seo</th>
                                <th>Performance</th>
                                <th>Best Practices</th>
                                <th>Strategy</th>
                                <th>Datetime</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <tr>
                                <td colSpan="8">
                                    <div class="text-center py-9">
                                        No results found.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>    
                <div id="paginator">
                </div>            
            </div>
        </div>
        @push('layout.scripts')
        <script>
            $(document).ready(function() {

                var actual_page = 1;

                getMetricHistory();

                $("#sync-button").on('click', function(e) {
                    getMetricHistory();
                });

                function getMetricHistory() {

                    $('#spinner-history').show();

                    $.ajax({
                        type: 'GET',
                        url: '/api/services/get_history?page=' + actual_page,
                        contentType: false,
                        cache: false,
                        processData: false,
                        timeout: 60000,
                        success: function(res) {
                            (res.meta.total) ? drawTable(res): '';
                            $('#spinner-history').hide();
                        },
                        error: function(res) {
                            $('#spinner-history').hide();
                            Toast.fire({
                                icon: 'error',
                                title: 'There was an error when bringing the information.'
                            })
                        }
                    });

                }

                function drawTable(result) {

                    $('#table-body').html('');

                    $.each(result.data, function(index, element) {

                        drawRow(element);

                    });

                    drawPaginator(result.meta);

                }

                function getClassByScore(score) {

                    if (score > 0.75) {
                        return 'success';
                    } else if (score > 0.50) {
                        return 'primary';
                    } else if (score > 0.25) {
                        return 'warning';
                    } else {
                        return 'danger';
                    }

                }

                function drawRow(data) {

                    let tr = $('<tr class="text-center"></tr>');
                    let url_td = $('');
                    let accesibility_td = $('');
                    let pwa_td = $('');
                    let seo_td = $('');
                    let performance_td = $('');
                    let best_practices_td = $('');
                    let strategy_td = $('');
                    let datetime_td = $('');

                    url_td = $('<td>' + data.url + '</td>');
                    accesibility_td = (data.accesibility_metric) ? $('<td><div class="text-' + getClassByScore(data.accesibility_metric) + ' mr-1">' + data.accesibility_metric + '</div></td>') : $('<td></td>');
                    pwa_td = (data.pwa_metric) ? $('<td><div class="text-' + getClassByScore(data.pwa_metric) + ' mr-1">' + data.pwa_metric + '</div></td>') : $('<td></td>');
                    seo_td = (data.seo_metric) ? $('<td><div class="text-' + getClassByScore(data.seo_metric) + ' mr-1">' + data.seo_metric + '</div></td>') : $('<td></td>');
                    performance_td = (data.performance_metric) ? $('<td><div class="text-' + getClassByScore(data.performance_metric) + ' mr-1">' + data.performance_metric + '</div></td>') : $('<td></td>');
                    best_practices_td = (data.best_practices_metric) ? $('<td><div class="text-' + getClassByScore(data.best_practices_metric) + ' mr-1">' + data.best_practices_metric + '</div></td>') : $('<td></td>');
                    strategy_td = $('<td>' + data.strategy + '</td>');
                    datetime_td = $('<td>' + data.created_at + '</td>');

                    url_td.appendTo(tr);
                    accesibility_td.appendTo(tr);
                    pwa_td.appendTo(tr);
                    seo_td.appendTo(tr);
                    performance_td.appendTo(tr);
                    best_practices_td.appendTo(tr);
                    strategy_td.appendTo(tr);
                    datetime_td.appendTo(tr);

                    tr.appendTo($('#table-body'));

                }

                $('body').on('click', '.page-link', function(event) {

                    let page = $(this).html();

                    switch ($(this).html()) {
                        case 'Previous':
                            actual_page = parseInt(actual_page) - parseInt(1);
                            getMetricHistory();
                            break;
                        case 'Next':
                            actual_page = parseInt(actual_page) + parseInt(1);
                            getMetricHistory();
                            break;
                        default:
                            actual_page = page;
                            getMetricHistory();
                            break;
                    }

                });

                function drawPaginator(data) {

                    $('#paginator').html('');

                    let li = $('');
                    let label = '';
                    let active = '';
                    let disabled = '';
                    let url = '';
                    let card_footer = $('<div class="card-footer clearfix"></div>');
                    let ul = $('<ul class="pagination pagination-sm m-0 float-right"></ul>');

                    $.each(data.links, function(index, element) {

                        switch (element.label) {
                            case '&laquo; Previous':
                                label = 'Previous';
                                break;
                            case 'Next &raquo;':
                                label = 'Next';
                                break;
                            default:
                                label = element.label;
                        }

                        disabled = (!element.url) ? 'disabled' : '';
                        active = (element.active) ? 'active' : '';
                        li = $('<li class="page-item ' + disabled + ' ' + active + '"><a class="page-link" href="#">' + label + '</a></li>');

                        li.appendTo(ul);

                    });

                    ul.appendTo(card_footer);
                    card_footer.appendTo($('#paginator'));

                }

            });
        </script>
        @endpush
</x-layout>