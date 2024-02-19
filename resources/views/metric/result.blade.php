<div class="row" id="result-card" style="display: none;">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h5 class="card-title">Result</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4" id="row-metrics-result">
                </div>
                <div class="justify-content-end">
                    <button class="btn btn-success" name="save-metrics" id="save-metrics" value="save-metrics">Save Metrics</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@push('layout.scripts')
<script>
    $(document).ready(function() {

        $("#save-metrics").on('click', function(e) {

            $('#text-spinner-run').html('Saving...');
            $('#spinner-run').show();

            let metrics = JSON.parse(sessionStorage.getItem("metrics"));
            let form_data = new FormData();

            metrics = JSON.parse(sessionStorage.getItem("metrics"));
            metrics.url;

            form_data.append('scores', JSON.stringify(metrics.scores));
            form_data.append('url', metrics.url);
            form_data.append('strategy', metrics.strategy);

            $.ajax({
                type: 'POST',
                url: '{{ route("metric.save_metrics") }}',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                timeout: 60000,
                success: function(res) {
                    var response = JSON.parse(res);
                    $('#spinner-run').hide();
                    if (response.state == 'ok') {
                        Toast.fire({
                            icon: 'success',
                            title: 'The metrics were saved successfully.'
                        })
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'The metrics could not be saved.'
                        })
                    }
                },
                error: function(res) {
                    $('#spinner-run').hide();
                    Toast.fire({
                        icon: 'error',
                        title: 'The metrics could not be saved.'
                    })
                }
            });
            
        });

    });
</script>
@endpush