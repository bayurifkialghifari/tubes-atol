<?php $this->load->view('templates/header') ?>

<!-- Page Content -->
<div class="page-content">
  
  <!-- GGWP -->
  <div class="content clearfix">
		
		<div id="colors" class="container mb-5">

			<div class="section-title col-lg-8 col-md-10 ml-auto mr-auto text-center">
			  <h3 class="mb-4 text-uppercase">My Order</h3>
			</div>

			<div class="example col-md-10 ml-auto mr-auto">
				<table class="table table-striped table-bordered" id="table">
					<thead>
						<tr>
							<th>Id</th>
							<th>From</th>
							<th>To</th>
							<th>Driver</th>
							<th>User</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($data as $d) : ?>
							<tr>
								<td><?= $d['tran_id'] ?></td>
								<td><?= $d['tran_asal'] ?></td>
								<td><?= $d['tran_tujuan'] ?></td>
								<td><?= $d['driver'] ?></td>
								<td><?= $d['user'] ?></td>
								<td><?= $d['tran_status'] ?></td>
								<td>
									<?php if($this->session->userdata('data')['level'] == 'User') : ?>
										<a href="<?= base_url() ?>pesan/motor?tran_id=<?= $d['tran_id'] ?>" class="btn btn-success btn-sm">Detail</a>
									<?php else : ?>
										<a href="<?= base_url() ?>dashboard?tran_id=<?= $d['tran_id'] ?>" class="btn btn-success btn-sm">Detail</a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

		</div>

	</div>
	<!-- GGWP -->

</div>

<?php $this->load->view('templates/footer') ?>
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(() => {
		$('#table').DataTable({
			order: [[0, 'desc']],
		})
	})
</script>
