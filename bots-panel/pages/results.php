<?php
include_once '../include/header/header_stats.php';
?>
<!-- Navbar -->
<? include_once '../include/navbar/navbar.php' ?>

<!-- Main Sidebar Container -->
<? include_once '../include/main-sidebar/main-sidebar.php' ?>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Результаты</h1>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
          <div class="container-fluid">
            <div class="shadow">
							<div class="container p-4">
                <? if($_SESSION['alert']): ?>
								<div class="alert border-left-warning alert-dismissible fade show mt-3" role="alert" style="border-left: .25rem solid #1ef600!important;">
												<?=$_SESSION['alert']?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
												</button>
										</div>
                  <? unset($_SESSION['alert']); ?>
                    </div>
                <? endif; ?>

                <div class="card-body">
									<div class="table-responsive">
										<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>#</th>
													<th>ФИО</th>
													<th>Результат</th>
													<th>Тест</th>
													<th>Дата</th>
													<th>Удалить</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>#</th>
													<th>ФИО</th>
													<th>Результат</th>
													<th>Тест</th>
													<th>Дата</th>
													<th>Удалить</th>
												</tr>
											</tfoot>
											<tbody>
												<tr class="pt-5 pb-5">
													<?
														$users = $Database->GetUserResults($_SESSION['userId']);
														if($users):
														for($i = 0; $i < count($users); $i++):
														?>
														<td>
																<?=$i + 1?>
														</td>
														<td>
														<div class="d-flex">
															<div style="width: 25px">
																<img src="<?=$users[$i]['Photo']?>" alt="" style="border-radius: 50%; width: 100%; height: 25px">
															</div>
															<div class="col-lg-10">
																<a href="https://vk.com/id<?=$users[$i]['PeerId']?>" target="_blank"><?=$users[$i]['FullName']?></a>
															</div>
														</div>
													</td>
													<td>
															<?=$users[$i]['SUM(Answers.Correct)']?>/<?=$users[$i]['COUNT(UserResults.Id)']?>
													</td>
													<td>
															<?=$users[$i]['Name']?>
													</td>
													<td>
															<?=$users[$i]['Date']?>
													</td>
													<td><a href="#delResult<?=$i?>" class="btn btn-danger" data-toggle="modal">Удалить</a></td>
												</tr>
												<?endfor;?>
											</tbody>
										</table>

										<?for($i = 0; $i < count($users); $i++):?>
											<div class="modal fade" id="delResult<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
															<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Удаление результата</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
															</div>
															<div class="modal-body">
																	<form action="actions/action_user_results.php?method=del" method="post">
																			<div class="md-form mt-4" style="display: none">
																					<label for="Id">id</label>
																					<input type="text" id="Id" class="form-control" name="Id" value="<?=$users[$i]['Id']?>" maxlength="20">
																			</div>
																			<h3 class="text-center">Вы действительно хотите удалить результат пользователя "<?=$users[$i]['FullName']?>"?</h3>
																			<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-danger btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Удалить</button>
																			</div>
																	</form>
															</div>
															<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
															</div>
													</div>
											</div>
							</div>
                    <?endfor;?>
										<?else:?>
										<div class="alert border-left-warning alert-dismissible fade show mt-3" role="alert" style="border-left: .25rem solid #f6ec00!important;">
												Результатов еще нету
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
												</button>
										</div>
										<?endif;?>

								</div>
							</div>
            </div>
          </div>
        </div>
			</div>

    <!-- Control Sidebar -->
<? include_once '../include/control-sidebar/control-sidebar.php' ?>
    <!-- /.control-sidebar -->


    <!-- Main Footer -->
<? include_once '../include/footer/footer_stats.php' ?>
