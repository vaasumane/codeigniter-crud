<div class="container pt-5">
    <div class="row center-form justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">Add Customer</h5>
                    </div>
                    <form id="customerForm" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="number" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile Number" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description" required></textarea>
                        </div>
                        <button type="submit" id="submit-customer" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <table id="customer-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Customer Name</th>
                        <th>Mobile No.</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCustomerForm">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="editName">
                    </div>
                    <div class="mb-3">
                        <label for="editMobile" class="form-label">Mobile Number</label>
                        <input type="number" class="form-control" id="editMobile" name="editMobile">
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail">
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="editDescription" rows="3" placeholder="Enter Description" required></textarea>
                    </div>
                    <input type="hidden" id="editCustomerId" name="customerIds">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>