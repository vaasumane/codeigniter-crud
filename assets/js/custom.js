
$(document).ready(function () {
    if($("#deviceSelect").length){
        $('#deviceSelect').select2();
    }
	if ($("#device-table").length) {
		$("#device-table").DataTable({
			processing: true,
			serverSide: true,
			paging: true,
			searching: true,
			ordering: true,
			info: true,
			ajax: {
				url: base_url + "Home/getDevices",
				type: "POST",
			},
			order: [[0, "desc"]],
			columns: [{ data: "id" }, { data: "device_id" }, { data: "device_name" }],
		});
	}
	$("#device-submit").click(function (e) {
		e.preventDefault();
		e.stopPropagation();
		var DeviceFormdata = new FormData($("#DeviceForm")[0]);
		$.ajax({
			url: base_url + "Home/addDevice",
			type: "POST",
			dataType: "json",
			data: DeviceFormdata,
			processData: false,
			contentType: false,
			success: function (response) {
				console.log(response);
				if (response.status) {
					toastr.success(response.message);
					$("#device-table").DataTable().ajax.reload();
					$("#DeviceForm")[0].reset();
				} else {
					toastr.error(response.message);
				}
			},
			error: function (xhr, status, error) {
				console.error(xhr.responseText);
			},
		});
	});
	if ($("#customer-table").length) {
		$("#customer-table").DataTable({
			processing: true,
			serverSide: true,
			paging: true,
			searching: true,
			ordering: true,
			info: true,
			ajax: {
				url: base_url + "Customer/getCustomers",
				type: "POST",
			},
			order: [[0, "desc"]],
			columnDefs: [{ orderable: false, targets: [4] }],
			columns: [
				{ data: "id" },
				{ data: "name" },
				{ data: "mobile_number" },
				{ data: "email" },
				{ data: "action" },
			],
		});
	}

	$("#submit-customer").click(function (e) {
		e.preventDefault();
		e.stopPropagation();
		var formData = new FormData($("#customerForm")[0]);

		$.ajax({
			url: base_url + "Customer/addCustomer",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.status) {
					toastr.success(response.message);
					$("#customer-table").DataTable().ajax.reload();
					$("#customerForm")[0].reset();

				} else {
					toastr.error(response.message);
				}
			},
			error: function (xhr, status, error) {
				toastr.error("An error occurred while adding the customer.");
				console.error(xhr.responseText);
			},
		});
	});
	$("#customer-table").on("click", ".btn-edit", function () {
		var customerId = $(this).data("id");
		$.ajax({
			url: base_url + "Customer/getCustomerDetails",
			type: "POST",
			dataType: "json",
			data: { customerId: customerId },
			success: function (response) {
				if (response.status) {

					$("#editName").val(response.customer.name);
					$("#editMobile").val(response.customer.mobile_number);
					$("#editEmail").val(response.customer.email);
					$("#editDescription").val(response.customer.description);
					$("#editCustomerId").val(customerId);
					$("#editCustomerModal").modal("show");
				} else {
					toastr.error("Failed to fetch customer details.");
				}
			},
			error: function (xhr, status, error) {
				toastr.error("An error occurred while fetching customer details.");
				console.error(xhr.responseText);
			},
		});
	});

	$("#saveEditBtn").click(function () {
        var formData = new FormData($("#editCustomerForm")[0]);

		$.ajax({
			url: base_url+"Customer/updateCustomer",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.status) {
					toastr.success(response.message);
                    $("#customer-table").DataTable().ajax.reload();
					$("#editCustomerModal").modal("hide");
					$("#editCustomerForm")[0].reset();

				} else {
					toastr.error(response.message);
				}
			},
			error: function (xhr, status, error) {
				toastr.error("An error occurred while updating the customer.");
				console.error(xhr.responseText);
			},
		});
	});
    if ($("#map-table").length) {
		$("#map-table").DataTable({
			processing: true,
			serverSide: true,
			paging: true,
			searching: true,
			ordering: true,
			info: true,
			ajax: {
				url: base_url + "CustomerMap/getMapDevices",
				type: "GET",
			},
			order: [[0, "desc"]],
			columnDefs: [{ orderable: false, targets: [1,3] }],
			columns: [
				{ data: "id" },
				{ data: "name" },
				{ data: "device_id" },
				{ data: "action" },
			],
		});
	}
    $("#map-submit").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var formData = new FormData($("#mapDeviceForm")[0]);

        $.ajax({
            url: base_url+"/CustomerMap/mapDevices",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
			contentType: false,
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                    $("#map-table").DataTable().ajax.reload();
                    $("#mapDeviceForm")[0].reset();
                    $('#deviceSelect').val(null).trigger('change');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error("An error occurred while adding the map.");
                console.error(xhr.responseText);
            }
        });
    });
});
