<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Bookings-Summary</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="data-table table table-hover table-striped table-sm " id="table-1">
                            <thead>
                                <tr>
                                    <th width="100" class="text-center">#</th>
                                    <th>Booking</th>
                                    <th width="100">BL No</th>
                                    <th>Custom BL No</th>
                                    <th>Customer</th>
                                    <th>Containers</th>
                                    <th>Invoices</th>
                                    <th>Payments</th>
                                    <th>Rate Applied</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($rows)
                                @foreach($rows as $row)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$row->booking}}</td>
                                    <td>{{$row->bl_no}}</td>
                                    <td>{{$row->custom_bl}}</td>
                                    <td>{{$row->customer_name}}</td>
                                    <td>{{$row->containers_count}}</td>
                                    <td>{{$row->invoices_count}}</td>
                                    <td>{{$row->payments_count}}</td>
                                    <td>{{$row->rates_applied_count}}</td>
                                    <td>{{$row->date}}</td>
                                    <td>{{$row->status}}</td>
                                    <td style="width: 400px" class="text-center">
                                        <?php if (has_permission(250)) { ?>
                                            <button type="button" class="btn btn-outline-primary view-details" data-id="{{$row->booking}}" data-toggle="modal" data-target="#exampleModal">
                                                <i class="far fa-eye"></i> View
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-admin>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="max-width: 1200px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Container Details for Booking: <span id="booking_number"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body p-0">
            <div class="mb-3">
                <input
                type="text"
                id="tableSearch"
                class="form-control"
                placeholder="Search containers..."
                />
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped" id="containerTable">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Container</th>
                  <th>Open Cargo</th>
                  <th>Size</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Loading Port</th>
                  <th>Offload</th>
                  <th>Weight</th>
                  <th>Cross Stuffing Status</th>
                  <th>Detention Start Date</th>
                  <th>Vehicle Number</th>
                  <th>Vehicle Type</th>
                </tr>
              </thead>
              <tbody id="containers_table_body">
                <tr>
                  <td colspan="10" class="text-center">No data available</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="containers-modal-footer" class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $(".view-details").on("click", function () {
        const id = $(this).data("id");

        $("#booking_number").text(id ? id : "N/A");

        $("#containers_table_body").html(
        '<tr><td colspan="12" class="text-center">Loading...</td></tr>'
        );

        const url = `<?= url("/bookings/summary/show") ?>/${id}`;

        $.ajax({
        url: url,
        type: "GET",
        contentType: "json",
        success: function (response) {
            let rows = "";

            if (response.data && response.data.containers.length > 0) {
                response.data.containers.forEach(container => {
                    rows += `
                    <tr>
                        <td>${container.index}</td>
                        <td>${container.container_no}</td>
                        <td>${container.open_cargo_status}</td>
                        <td>${container.size}</td>
                        <td>${container.status}</td>
                        <td>${container.date}</td>
                        <td>${container.loading_port}</td>
                        <td>${container.off_loading_port}</td>
                        <td>${container.container_weight}</td>
                        <td>${container.cross_stuffing_status}</td>
                        <td>${container.detention_start_date}</td>
                        <td>${container.vehicle_no}</td>
                        <td>${container.vehicle_type}</td>
                    </tr>`;
                });
                $("#containers-modal-footer").show();
            } else {
                rows = '<tr><td colspan="12" class="text-center">No containers found</td></tr>';
                $("#containers-modal-footer").hide();
            }

            $("#containers_table_body").html(rows);
        },
        error: function () {
            console.error("Failed to fetch container data");
            $("#containers_table_body").html(
                '<tr><td colspan="10" class="text-center text-danger">Error loading data</td></tr>'
            );
        },
    });
  });

    $("#tableSearch").on("input", function () {
        const value = $(this).val().toLowerCase();
        $("#containers_table_body tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
  });
</script>
