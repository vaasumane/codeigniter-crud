<div class="container pt-4">
    <div class="row center-form justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Assign Device</h5>
                    <form id="mapDeviceForm">
                        <div class="mb-3">
                            <label for="deviceSelect" class="form-label">Select Device</label>
                            <select multiple="multiple" class="form-select" id="deviceSelect" name="device_id[]">
                                <?php foreach ($devices as $device) { ?>
                                    <option value="<?php echo $device["id"] ?>"><?php echo $device["device_id"] ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="customerSelect" class="form-label">Select Customer</label>
                            <select class="form-select" id="customerSelect" name="customer_name">
                            <?php foreach ($customers as $customer) { ?>
                                    <option value="<?php echo $customer["id"] ?>"><?php echo $customer["name"] ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <button type="submit" id="map-submit" class="btn btn-primary">Map Device</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <table id="map-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Customer Name</th>
                        <th>Device ID</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
