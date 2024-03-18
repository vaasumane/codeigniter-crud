<div class="container pt-5">
    <div class="row center-form justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
					<div class="d-flex justify-content-between">
                    	<h5 class="card-title">Add Device</h5>
					
					</div>
                    <form id="DeviceForm" method="post">
                        <div class="mb-3">
                            <label for="device_id" class="form-label">Device Id</label>
                            <input type="number" class="form-control" id="device_id" name="device_id" placeholder="Enter Device Id" maxlength="11">
                        </div>
                        <div class="mb-3">
                            <label for="device_name" class="form-label">Device Name</label>
                            <input type="text" class="form-control" id="device_name" name="device_name" placeholder="Enter Device Name">
                        </div>
                        <button type="submit" id="device-submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <table id="device-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Device Id</th>
                        <th>Device Name</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>