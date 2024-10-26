<x-layout-admin>

    <?php if (!isset($_REQUEST['submit'])) { ?>
        <div class="row">
            <div class="col-12">
                <form method="post" action="" enctype='multipart/form-data'>
                    @csrf
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Choose Criteria</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="party_id">Customer Name</label>
                                        <select class="form-control select2" id="party_id" name="party_id">
                                            <option value="">--select--</option>
                                            @if($customers)
                                            @foreach($customers as $row)
                                            <option value="{{$row->id}}">{{$row->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Customers List</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover report-datatable table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width="80" class="text-center">Custosmer ID</th>
                                        <th>Custosmer Name</th>
                                        <th>Credit Days</th>
                                        <th>Credit Limit</th>
                                        <th>Customer Address</th>
                                        <th>Email Address</th>
                                        <th>Contact number</th>
                                        <th>Contact Person</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (COUNT($rows)) {
                                        foreach ($rows as $row) {
                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $row->id; ?></td>
                                                <td><?= $row->title; ?></td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td><?= $row->address; ?></td>
                                                <td><?= $row->email; ?></td>
                                                <td><?= $row->contact; ?></td>
                                                <td><?= $row->contact_person; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</x-layout-admin>