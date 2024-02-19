<div class="row">
    <div class="col-md-12">
        <div class="card card-indigo">
            <div class="card-header">
                <h3 class="card-title">Search</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>URL</label>
                            <input class="form-control" id="url" placeholder="URL" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <div id="url-invalid-feedback" class="invalid-feedback"></div>
                            <div id="url-valid-feedback" class="valid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Categories</label>
                            <select class="form-control" id="categories" name="categories" multiple="multiple">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id}}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="categories-invalid-feedback" class="invalid-feedback"></div>
                            <div id="categories-valid-feedback" class="valid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Strategy</label>
                            <select class="form-control" id="strategy" name="strategy">
                                <option></option>
                                @foreach ($strategies as $strategy)
                                <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                                @endforeach
                            </select>
                            <div id="strategy-invalid-feedback" class="invalid-feedback"></div>
                            <div id="strategy-valid-feedback" class="valid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="justify-content-end">
                    <button class="btn btn-info" name="get-metrics" id="get-metrics" value="get-metrics">Get Metrics</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('layout.scripts')
<script>
    $(document).ready(function() {

        $('#categories').select2({
            placeholder: "Categories",
            theme: 'bootstrap4',
            allowClear: true,
            multiple: true,
        });

        $('#strategy').select2({
            placeholder: "Strategy",
            theme: 'bootstrap4',
            allowClear: true,
        });

        $("#url").focusout(function() {
            validateURL();
        });

        $('#categories').on('select2:close select2:clear select2:unselect', function(e) {
            validateCategories();
        });

        $('#strategy').on('select2:close select2:clear select2:unselect', function(e) {
            validateStrategy();
        });

        $("#get-metrics").on('click', function(e) {

            $('#result-card').hide();

            if (validateForm()) {

                $('#text-spinner-run').html('Sending...');
                $('#spinner-run').show();

                let form_data = new FormData();
                let url = $('#url').val()
                let strategy = $('#strategy').val()
                let categories = [];

                $("#categories :selected").map((_, element) => {

                    categories.push(parseInt(element.value));

                }).get();

                form_data.append('categories', JSON.stringify(categories));
                form_data.append('url', url);
                form_data.append('strategy', strategy);

                $.ajax({
                    type: 'POST',
                    url: '{{ route("metric.get_metrics") }}',
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    timeout: 60000,
                    success: function(res) {
                        var response = JSON.parse(res);
                        if (response.state == 'ok') {
                            saveMetricsInLocalStorage(url, strategy, response.scores);
                            drawCharts(response.scores);
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'There was an error while performing the search.'
                            })
                        }
                        $('#spinner-run').hide();
                        $('#result-card').show();
                    },
                    error: function(res) {
                        $('#spinner-run').hide();
                        Toast.fire({
                            icon: 'error',
                            title: 'There was an error while performing the search.'
                        })
                    }
                });
            }
        });

        function saveMetricsInLocalStorage(url, strategy, scores) {

            sessionStorage.clear();

            let metrics = {
                'url': url,
                'strategy': strategy,
                'scores': scores,
            }

            sessionStorage.setItem('metrics', JSON.stringify(metrics));

        }

        function drawCharts(scores) {

            $('#row-metrics-result').html('');

            $.each(scores, function(index, element) {

                let principal_div = $('');
                let input = $('');
                let label = $('');

                if (index == 0) {
                    principal_div = $('<div class="col-sm-4 col-md-2 offset-md-' + (6 - scores.length) + ' text-center"></div>');
                } else {
                    principal_div = $('<div class="col-sm-4 col-md-2 text-center"></div>');
                }

                input = $('<input type="text" data-step="0.1" value="' + element.score + '" class="dial" id="' + element.id + '-dial">');
                label = $('<div class="knob-label">' + element.title + '</div>');

                input.appendTo(principal_div);
                label.appendTo(principal_div);
                principal_div.appendTo($('#row-metrics-result'));

                $('#' + element.id + '-dial').knob({
                    width: 125,
                    height: 125,
                    max: 1,
                    fgColor: getColorByScore(element.score),
                    readOnly: true,
                });

            });

        }

        function getColorByScore(score) {

            if (score > 0.75) {
                return '#28a745';
            } else if (score > 0.50) {
                return '#007bff';
            } else if (score > 0.25) {
                return '#ffc107';
            } else {
                return '#dc3545';
            }

        }

        function validateForm() {

            let no_errors = true;

            (!validateURL()) ? no_errors = false: '';
            (!validateCategories()) ? no_errors = false: '';
            (!validateStrategy()) ? no_errors = false: '';

            return no_errors;

        }

        function validateURL() {

            let url = $('#url').val();
            $('#url').removeClass('is-invalid');
            $('#url').removeClass('is-valid');

            if (!url) {
                setMensajeInput('url-invalid-feedback', 'Please enter a url.');
                $('#url').addClass('is-invalid');
                return false;
            } else {

                var reg = new RegExp(/^http(s){0,1}\:(\/){2}([a-zA-Z0-9\-_]+\@){0,1}(((www\.){0,1}[a-zA-Z0-9\+\-\.]+\.[a-zA-Z]+){1}|(\d+(\.\d+)+){1})(:\d+){0,1}(\/){0,1}$/);

                if (!reg.test(url)) {
                    setMensajeInput('url-invalid-feedback', 'Please enter a valid url.');
                    $('#url').addClass('is-invalid');
                } else {
                    setMensajeInput('url-valid-feedback', 'Looks good!');
                    $('#url').addClass('is-valid');
                    return true;
                }

            }

        }

        function validateCategories() {

            let categories = [];
            $('#categories').removeClass('is-invalid');
            $('#categories').removeClass('is-valid');

            $("#categories :selected").map((_, element) => {
                categories.push(element.value);
            }).get();

            if (categories.length == 0) {
                setMensajeInput('categories-invalid-feedback', 'Please select at least one option.');
                $('#categories').addClass('is-invalid');
                return false;
            } else {
                setMensajeInput('categories-valid-feedback', 'Looks good!');
                $('#categories').addClass('is-valid');
                return true;
            }

        }

        function validateStrategy() {

            let strategy = $('#strategy').val();
            $('#strategy').removeClass('is-invalid');
            $('#strategy').removeClass('is-valid');

            if (!strategy) {
                setMensajeInput('strategy-invalid-feedback', 'Please select an option.');
                $('#strategy').addClass('is-invalid');
                return false;
            } else {
                setMensajeInput('strategy-valid-feedback', 'Looks good!');
                $('#strategy').addClass('is-valid');
                return true;
            }

        }

    });
</script>
@endpush