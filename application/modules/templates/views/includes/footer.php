<!-- Footer opened -->
<div class="main-footer ht-40">
	<div class="container-fluid pd-t-0-f ht-100p">
		<span>Copyright &copy; <?php echo date('Y'); ?><a href="https://www.africacdc.org/">Africa CDC</a> All rights
			reserved.</span>
	</div>
</div>
<!-- Footer closed -->


<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

<!-- JQuery min js -->
<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>

<!-- Popper js -->
<script src="<?php echo base_url() ?>assets/plugins/popper/popper.min.js"></script>

<!-- Bootstrap Bundle js -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Ionicons js -->
<script src="<?php echo base_url() ?>assets/plugins/ionicons/ionicons.js"></script>

<!-- Moment js -->
<script src="<?php echo base_url() ?>assets/plugins/moment/moment.js"></script>

<!-- Sparkline js -->
<script src="<?php echo base_url() ?>assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- Piety js -->
<script src="<?php echo base_url() ?>assets/plugins/peity/jquery.peity.min.js"></script>

<!-- P-scroll js -->
<script src="<?php echo base_url() ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/perfect-scrollbar/p-scroll.js"></script>

<!-- Horizontalmenu js-->
<script src="<?php echo base_url() ?>assets/plugins/horizontal-menu/horizontal-menu.js"></script>

<!--- Colorchange js -->
<script src="<?php echo base_url() ?>assets/js/color-change.js"></script>

<!-- Internal Flot js-->
<script src="<?php echo base_url() ?>assets/plugins/jquery.flot/jquery.flot.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery.flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery.flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery.flot/jquery.flot.categories.js"></script>

<!-- Internal Chart js-->
<script src="<?php echo base_url() ?>assets/plugins/chart.js/Chart.bundle.min.js"></script>

<!-- Rating js-->
<script src="<?php echo base_url() ?>assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/rating/jquery.barrating.js"></script>

<!-- Internal Echart Plugin -->
<script src="<?php echo base_url() ?>assets/plugins/echart/echart.js"></script>

<!-- Tooltip js -->
<script src="<?php echo base_url() ?>assets/js/tooltip.js"></script>

<!-- Internal Index js -->
<script src="<?php echo base_url() ?>assets/js/index.js" id="change-js"></script>
<script src="<?php echo base_url() ?>assets/js/dashboard.sampledata.js"></script>
<script src="<?php echo base_url() ?>assets/js/chart.flot.sampledata.js"></script>

<!-- Right-sidebar js -->
<script src="<?php echo base_url() ?>assets/plugins/sidebar/sidebar.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/sidebar/sidebar-custom.js"></script>

<!-- Custom js -->
<script src="<?php echo base_url() ?>assets/js/custom.js"></script>

<!-- Add Select2 Nodemodules -->
<link href="<?php echo base_url() ?>node_modules/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url() ?>node_modules/select2/dist/js/select2.min.js"></script>

<!-- Add TinyMCE Nodemodules -->
<script src="<?php echo base_url() ?>node_modules/tinymce/tinymce.min.js"></script>

<!-- Add Sweetalert2 Nodemodule -->
<script src="<?php echo base_url() ?>node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

<link rel="stylesheet" type="text/css"
	href="https://cdn.datatables.net/v/dt/dt-1.13.1/b-2.3.3/b-html5-2.3.3/datatables.min.css" />

<script type="text/javascript"
	src="https://cdn.datatables.net/v/dt/dt-1.13.1/b-2.3.3/b-html5-2.3.3/datatables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
	$(document).ready(function () {
		// Handle deactivate button click
		// CSRF token from a meta tag or hidden input
       var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
	   var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    // Handle deactivate button click
    $('.deactivate-btn').click(function () {
        var id = $(this).data('id');
        var row = $('#outbreak-' + id);

        swal({
            title: "Are you sure?",
            text: "This will deactivate the outbreak.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDeactivate) => {
            if (willDeactivate) {
                // Make an AJAX POST request to update the status
                $.ajax({
                    url: "<?= site_url('outbreaks/edit/'); ?>" + id + "/inactive",
                    type: "POST",
                    data: { [csrfName]: csrfHash },
                    success: function (response) {
                        swal("Success!", "The outbreak has been deactivated.", "success");
                        row.find('.status').text('Inactive');
                    },
                    error: function () {
                        swal("Error!", "Failed to deactivate the outbreak.", "error");
                    }
                });
            }
        });
    });



	
    // Get CSRF token from a meta tag or hidden input
            var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
			var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

			// Handle delete button click
			$('.delete-btn').click(function () {
				var id = $(this).data('id');
				var row = $('#outbreak-' + id);

				swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this outbreak!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				}).then((willDelete) => {
					if (willDelete) {
						// Make an AJAX POST request to delete the outbreak
						$.ajax({
							url: "<?= site_url('outbreaks/delete/'); ?>" + id,
							type: "POST",
							data: { [csrfName]: csrfHash },
							success: function (response) {
								swal("Deleted!", "The outbreak has been deleted.", "success");
								row.remove();
							},
							error: function () {
								swal("Error!", "Failed to delete the outbreak.", "error");
							}
						});
					}
				});
			});
		


		// Handle edit button click
		$('.edit-btn').click(function () {
			var id = $(this).data('id');
			var row = $('#outbreak-' + id);
			$('#outbreakId').val(id);
			$('#outbreakName').val(row.find('td:eq(1)').text());
			$('#outbreakType').val(row.find('td:eq(2)').text());
			$('#startDate').val(row.find('td:eq(3)').text());
			$('#endDate').val(row.find('td:eq(4)').text() !== 'Ongoing' ? row.find('td:eq(4)').text() : '');
			$('#severityLevel').val(row.find('td:eq(5)').text().toLowerCase());
			$('#status').val(row.find('.status').text().toLowerCase());
			$('#updateModal').modal('show');
		});


		var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

		// Handle form submission for updating
		$('#updateForm').submit(function (e) {
			e.preventDefault();
			var id = $('#outbreakId').val();
			var formData = $(this).serializeArray();

			// Add CSRF token to formData
			formData.push({ name: csrfName, value: csrfHash });

			$.post("<?= site_url('outbreaks/edit/'); ?>" + id, formData, function (response) {
				swal("Success!", "The outbreak has been updated successfully.", "success").then(() => {
					location.reload();
				});
			}).fail(function () {
				swal("Error!", "Failed to update the outbreak.", "error");
			});
		});
	});

</script>


<script>
	$(document).ready(function () {
		$('.select2').select2();
	});
</script>


<script>
	tinymce.init({
		selector: "textarea#description",
		plugins: [
			"insertdatetime"
		],
		width: "auto",
		height: 400,
	});
</script>


    <script>
        $(document).ready(function () {
            var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

		$('#addOutbreakForm').submit(function (e) {
			e.preventDefault();
			var formData = $(this).serializeArray();
			formData.push({ name: csrfName, value: csrfHash });

			$.ajax({
				url: "<?= site_url('outbreaks/add'); ?>",
				type: "POST",
				data: formData,
				success: function (response) {
					if (response.success) {
						swal("Success!", response.message, "success").then(() => {
							$('#addOutbreakForm')[0].reset();
						});
					} else {
						swal("Error!", response.message, "error");
					}
				},
				error: function () {
					swal("Error!", "Failed to add the outbreak.", "error");
				}
			});
		});
	});
</script>


    <script>
        $(document).ready(function () {
            var maxRows = 5;
            var rowIndex = 1; // Starts from 1 as there's already one row in the table

            // Display start and end dates when an outbreak is selected
            $('#outbreakSelect').change(function () {
                var selectedOption = $(this).find('option:selected');
                $('#startDate').text(selectedOption.data('start-date'));
                $('#endDate').text(selectedOption.data('end-date'));
            });

            // Add new row for menu items
            $('#addRow').click(function () {
                if ($('#menuItemsTable tr').length < maxRows) {
                    var newRow = `
                        <tr>
                            <td><input type="text" class="form-control" name="menu[${rowIndex}][name]" required></td>
                            <td><input type="text" class="form-control" name="menu[${rowIndex}][tab]" required></td>
                            <td><input type="text" class="form-control" name="menu[${rowIndex}][url]" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                        </tr>`;
                    $('#menuItemsTable').append(newRow);
                    rowIndex++;
                } else {
                    swal("Warning", "You can only add a maximum of 5 menu items.", "warning");
                }
            });

            // Remove a row
            $('#menuItemsTable').on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });

            // Handle form submission
            $('#assignMenuLinksForm').submit(function (e) {
                e.preventDefault();
                var outbreakId = $('#outbreakSelect').val();

                if (!outbreakId) {
                    swal("Error", "Please select an outbreak.", "error");
                    return;
                }

                var formData = $(this).serializeArray();
                formData.push({ name: 'outbreak_id', value: outbreakId });
                formData.push({ name: '<?= $this->security->get_csrf_token_name(); ?>', value: '<?= $this->security->get_csrf_hash(); ?>' });

			$.ajax({
				url: "<?= site_url('outbreaks/assign_menu_links'); ?>",
				type: "POST",
				data: formData,
				success: function (response) {
					if (response.success) {
						swal("Success!", response.message, "success").then(() => {
							location.reload();
						});
					} else {
						swal("Error!", response.message, "error");
					}
				},
				error: function () {
					swal("Error!", "Failed to assign menu links.", "error");
				}
			});
		});
	});
</script>

<!-- code to edit menu items -->
<script>
    $(document).ready(function () {
        var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

		// Load menu items when an outbreak is selected
		$('#outbreakSelect').change(function () {
			var outbreakId = $(this).val();
			if (outbreakId) {
				loadMenuItems(outbreakId);
			}
		});

		// Function to load menu items for an outbreak
		function loadMenuItems(outbreakId) {
			$.ajax({
				url: "<?= site_url('outbreaks/get_menu_links'); ?>/" + outbreakId,
				type: "GET",
				dataType: "json", // Ensure we expect a JSON response
				success: function (response) {
					if (response.success && response.menu_items.length > 0) {
						populateMenuItemsTable(response.menu_items);
					} else {
						swal("Info", "No menu items found for this outbreak.", "info");
						clearMenuItemsTable();
					}
				},
				error: function () {
					swal("Error!", "Failed to load menu items.", "error");
				}
			});
		}

		// Populate table with menu items
		function populateMenuItemsTable(menuItems) {
			var tableBody = $('#menuItemsTable tbody');
			tableBody.empty(); // Clear existing rows

			$.each(menuItems, function (index, item) {
				var newRow = `
					<tr>
						<td><input type="text" class="form-control" name="menu[${index}][name]" value="${item.name}" required></td>
						<td><input type="text" class="form-control" name="menu[${index}][title]" value="${item.title}" required></td>
						<td><input type="text" class="form-control" name="menu[${index}][tab]" value="${item.tab}" required></td>
						<td><input type="text" class="form-control" name="menu[${index}][url]" value="${item.url}" required></td>
						<td><input type="text" class="form-control" name="menu[${index}][icon]" value="${item.icon || ''}"></td>
						<td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
					</tr>`;
				tableBody.append(newRow);
			});
		}

		// Clear the table when no menu items are found
		function clearMenuItemsTable() {
			var tableBody = $('#menuItemsTable tbody');
			tableBody.empty(); // Clear existing rows
		}

		// Handle adding a new menu item
		$('#addRow').click(function () {
			var rowIndex = $('#menuItemsTable tbody tr').length;
			var newRow = `
				<tr>
					<td><input type="text" class="form-control" name="menu[${rowIndex}][name]" required></td>
					<td><input type="text" class="form-control" name="menu[${rowIndex}][title]" required></td>
					<td><input type="text" class="form-control" name="menu[${rowIndex}][tab]" required></td>
					<td><input type="text" class="form-control" name="menu[${rowIndex}][url]" required></td>
					<td><input type="text" class="form-control" name="menu[${rowIndex}][icon]"></td>
					<td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
				</tr>`;
			$('#menuItemsTable tbody').append(newRow);
		});

		// Remove a menu item row
		$('#menuItemsTable').on('click', '.remove-row', function () {
			$(this).closest('tr').remove();
		});

		// Submit the form to save menu items
		$('#editMenuLinksForm').submit(function (e) {
			e.preventDefault();
			var outbreakId = $('#outbreakSelect').val();

			if (!outbreakId) {
				swal("Error", "Please select an outbreak.", "error");
				return;
			}

			var formData = $(this).serializeArray();
			formData.push({ name: 'outbreak_id', value: outbreakId });
			formData.push({ name: csrfName, value: csrfHash });

			$.ajax({
				url: "<?= site_url('outbreaks/update_menu_links'); ?>",
				type: "POST",
				data: formData,
				success: function (response) {
					if (response.success) {
						swal("Success!", response.message, "success").then(() => {
							loadMenuItems(outbreakId); // Reload menu items
						});
					} else {
						swal("Error!", response.message, "error");
					}
				},
				error: function () {
					swal("Error!", "Failed to update menu items.", "error");
				}
			});
		});

		// Copy menu items from another outbreak and save as new entries for the target outbreak
		$('#copyMenuItems').click(function () {
			var sourceOutbreakId = $('#copyOutbreakSelect').val();
			var targetOutbreakId = $('#outbreakSelect').val();

			if (!sourceOutbreakId || !targetOutbreakId) {
				swal("Error", "Please select both outbreaks.", "error");
				return;
			}

			$.ajax({
				url: "<?= site_url('outbreaks/copy_menu_links'); ?>",
				type: "POST",
				data: {
					source_outbreak_id: sourceOutbreakId,
					target_outbreak_id: targetOutbreakId,
					[csrfName]: csrfHash
				},
				success: function (response) {
					if (response.success) {
						swal("Success!", response.message, "success").then(() => {
							loadMenuItems(targetOutbreakId); // Reload menu items for the target outbreak
						});
					} else {
						swal("Error!", response.message, "error");
					}
				},
				error: function () {
					swal("Error!", "Failed to copy menu items.", "error");
				}
			});
		});

		// Initial load if an outbreak is already selected
		var selectedOutbreakId = $('#outbreakSelect').val();
		if (selectedOutbreakId) {
			loadMenuItems(selectedOutbreakId);
		}
	});
</script>





</body>

</html>