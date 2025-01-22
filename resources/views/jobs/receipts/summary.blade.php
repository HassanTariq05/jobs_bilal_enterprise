<x-layout-admin>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Invoices Summary</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="data-table table table-hover table-striped table-sm" id="table-1">
                            <thead>
                                <tr>
                                    <th width="100" class="text-center">#</th>
                                    <th>Job No</th>
                                    <th>Customer Name</th>
                                    <th>Invoice No</th>
                                    <th>Items</th>
                                    <th>Receipts</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($rows && count($rows) > 0)
                                    @foreach($rows as $index => $row)
                                        @if($row->party_title)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $row->job_no }}</td>
                                                <td>{{ $row->party_title }}</td>
                                                <td>{{ $row->inv_no }}</td>
                                                <td>{{ $row->items_count ?? 0 }}</td>
                                                <td>{{ $row->receipt_count ?? 0 }}</td>
                                                <td class="d-flex justify-content-center text-center flex-row">
                                                    <a href="{{route('invoice-generate-pdf', $row->id)}}" class="dropdown-item" title="Edit Invoice List Items">
                                                        <i class="far fa-file-pdf mr-2"></i>
                                                        Generate Invoice PDF
                                                    </a>
                                                    <?php if (has_permission(250)) { ?>
                                                        <button type="button" class="btn btn-outline-primary view-details" data-id="{{$row->id}}" data-job="{{$row->job_id}}" data-toggle="modal" data-target="#exampleModal">
                                                            <i class="far fa-eye"></i> View
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No records found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
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
            <h5 class="modal-title" id="exampleModalLabel">Details for Invoice: <span id="invoice_number"></span></h5>
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
                    placeholder="Search Items..."
                    />
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped" id="containerTable">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Head</th>
                        <th>Description</th>
                        <th class="text-right">Amount Excluding Tax</th>
                        <th class="text-right">Sales Tax</th>
                        <th class="text-right">Invoice Amount</th>
                        <th class="text-center">Date</th>
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
    <!--  -->
<script>
  $(document).ready(function () {
    $(".view-details").on("click", function () {
        const inv_id = $(this).data("id");
        const job_id = $(this).data("job");

        $("#containers_table_body").html(
        '<tr><td colspan="10" class="text-center">Loading...</td></tr>'
        );

        const url = `<?= url("/jobs/receipts/summary/show") ?>/${job_id}/${inv_id}`;

        $.ajax({
            url: url,
            type: "GET",
            contentType: "json",
            success: function (response) {
                let rows = "";

            if (response.data && response.data.rows.length > 0) {
                response.data.rows.forEach((row, index) => {
                    rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row.account_title || ""}</td>
                        <td>${row.description || ""}</td>
                        <td>Rs.${row.amount || 0}</td>
                        <td>Rs.${row.tax || 0}</td>
                        <td>Rs.${row.net || 0}</td>
                        <td>${new Date(row.created_at).toLocaleDateString() || ""}</td>
                    </tr>`;
                });
                
            } else {
                $("#containers_table_body").html(
                    '<tr><td colspan="10" class="text-center text-danger">Error loading data</td></tr>'
                );
            }
            $("#containers-modal-footer").show();
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