    <x-layout-admin>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Job Performance Activity </h5>
                                <h4>List of all processed work orders ({{ $job->job_type }}) </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('edit-job', [Request::segment(3)])}}" class="btn btn-sm btn-dark">View Job</a>
                                <a href="{{route('create-job-performance', [Request::segment(3)])}}" class="btn btn-sm btn-primary">Add New</a>
                            </div>
                        </div>
                    </div>
                    <form id="assign_work_orders" method="post" action="{{route('assign-work-orders', [$job->id], )}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-sm data-table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Check</th>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Location</th>
                                            <th>BL Date</th>
                                            <th>Booking Date</th>
                                            <th>Loading Port</th>
                                            <th>Offload</th>
                                            <th>Booking</th>
                                            <th>No. of Containers</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($bookings->count())
                                        @foreach($bookings as $row)
                                        <tr>
                                            <td class="text-center"><input name="checked[{{$row->id}}]" type="checkbox"/></td>
                                            <td>{{$row->date}}</td>
                                            <td>{{$row->customer_name}}</td>
                                            <td>{{$row->location_name}}</td>
                                            <td>{{$row->date}}</td>
                                            <td>{{$row->created_at}}</td>
                                            <td>{{$row->lp_name}}</td>
                                            <td>{{$row->offload_name}}</td>
                                            <td>{{$row->booking}}</td>
                                            <td class="text-center">{{$row->total_containers}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="containers-modal-footer" class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Assign Work Orders</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-layout-admin>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="max-width: 1200px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Process Cross Stuffing for booking # <span id="booking_number"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="update_containers" method="post" action="{{route('update-containers', [$job->id, "--"], )}}" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm data-table" id="table-1">
                        <thead>
                            <tr>
                                <th>Container</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Loading Port</th>
                                <th>Offload</th>
                                <th>Weight</th>
                                <th>Cross Stuffing Status</th>
                                <th>Detentation Start Date</th>
                                <th>Cross Stuffing Container No.</th>
                                <th>Vehicle Type</th>
                                <th>Vehicle Number</th>
                            </tr>
                        </thead>
                        <tbody id="containers_table_body">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="containers-modal-footer" class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

fleet = <?= json_encode($fleet) ?>

$(".btn-primary").click(function() {
    setTimeout(() => {
        $(this).removeClass('btn-progress');
    }, 1000)
});

$('#containers_table_body').on('change', '.vehicle_type', function() {
    id = $(this).attr("data-id")
    if(this.value == "owned") {
        fleetStr = '<select name="vehicle_number[]" class="vehicle_number form-control" data-id="'+ id +'" required>'
        fleetStr += '<option value="">Select</option>'
        for(i=0; i<fleet.length; i++) {
            fleetStr += '<option value="'+fleet[i].registration_number+'">Reg# '+fleet[i].registration_number+'</option>'
        }
        fleetStr += '</select>'
        $("#vehicle_number_"+id).html(fleetStr)
    } else {
        $("#vehicle_number_"+id).html('<td><input name="vehicle_number[]" class="form-control" placeholder="Vehicle #" required/></td>')
    }
});

$(".view-details").on('click', function(event){

    id = $(this).attr("data-id");

    $("#containers_table_body").html("")
    $("#booking_number").html(""+id)

    url = "<?= url("/jobs/edit/".$job->id."/performance/containers/") ?>/"+id
    console.log(url)
    $.ajax({
        url: url,
        type: 'GET',
        contentType: 'json',
        success: function(json) {
            
            str = ""
            for(i=0; i<json.data.containers.length; i++) {

                str += "<tr>"
                c = json.data.containers[i]
                str += "<td>"+c.container_no+'<input type="hidden" name="container_ids[]" value="'+ c.id +'"/></td>'
                str += "<td>"+c.size+"</td>"
                str += "<td>"+c.status+"</td>"
                str += "<td>"+c.date+"</td>"
                str += "<td>"+c.loading_port+"</td>"
                str += "<td>"+c.off_loading_port+"</td>"
                if(c.container_weight == null){
                    str += "<td></td>"
                } else {
                    str += "<td>"+c.container_weight+"</td>"
                }
                if(c.cross_stuffing_status == null){
                    str += "<td></td>"
                } else {
                    str += "<td>"+c.cross_stuffing_status+"</td>"
                }
                if(c.detention_start_date == null){
                    str += "<td></td>"
                } else {
                    str += "<td>"+c.detention_start_date+"</td>"
                }
                if(c.cross_stuffing_status == "yes") {
                    str += '<td><input value="'+c.cross_stuffing_container_no+'" type="text" name="cross_stuffing_container_no[]" class="form-control" placeholder="Container #" pattern="^[A-Za-z]{4}[0-9]{7}$" title="Container ID must be 4 letters followed by 9 numbers with no spaces." required></td>'
                } else {
                    str += '<td><input type="hidden" name="cross_stuffing_container_no[]" value="--"/></td>'
                }
                str += '<td style="width: 150px">'+
                            '<select name="vehicle_type[]" class="vehicle_type form-control" data-id="'+ c.id +'" required>'+
                                '<option value="">Select</option>'+
                                '<option value="owned">Owned</option>'+
                                '<option value="private">Private</option>'+
                            '</select>'+
                        "</td>"
                str += '<td id="vehicle_number_'+c.id+'" style="width: 150px"></td>'
                str += "</tr>"

            }

            oldAction = document.getElementById("update_containers").action;
            arr = oldAction.split("/")
            arr[arr.length - 1] = id
            document.getElementById("update_containers").action = arr.join("/")
            if(json.data.containers.length <= 0) {
                $("#containers_table_body").html('<tr><td colspan="12"><label>No pending containers found ... </label></td></tr>')
                $('#containers-modal-footer').hide()
            } else {
                $("#containers_table_body").html(str)
                $('#containers-modal-footer').show()
            }

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(textStatus, errorThrown)
        },
    });

});

</script>
