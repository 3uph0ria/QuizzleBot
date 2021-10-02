<?php
include_once '../include/header/header.php';
?>
<!-- Navbar -->
<? include_once '../include/navbar/navbar.php' ?>

<!-- Main Sidebar Container -->
<? include_once '../include/main-sidebar/main-sidebar.php' ?>

<?php
$bots = $Database->GetBots($_SESSION['userId']);
?>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Редактирование Ботов</h1>
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

								<div class="container">
                	<a href="#addQuestion" class="btn btn-success my-2" data-toggle="modal">Добавить бота</a>
								</div>

                <div class="modal fade" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Добавить бота</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            </div>
                            <div class="modal-body">
                                <form action="actions/action_bots.php?method=add" method="post">
                                    <div class="md-form mt-4" style="display: none">
                                        <label for="IdUserPanel">id</label>
                                        <input type="text" id="IdUserPanel" class="form-control" name="IdUserPanel" value="<?=$_SESSION['userId']?>" maxlength="20">
                                    </div>
                                    <div class="md-form mt-4">
                                        <label for="TestId">ID теста</label>
                                        <input type="text" id="TestId"  class="form-control" name="TestId" maxlength="20">
                                    </div>
																		<div class="md-form mt-4">
                                        <label for="Name">Наименование (для удобства)</label>
                                        <input type="text" id="Name"  class="form-control" name="Name" maxlength="200">
                                    </div>
																		<div class="md-form mt-4">
                                        <label for="Token">Токен</label>
                                        <input type="text" id="Token"  class="form-control" name="Token" maxlength="200">
                                    </div>
																		<div class="md-form mt-4">
                                        <label for="ServerKey">Строка, которую должен вернуть сервер</label>
                                        <input type="text" id="ServerKey"  class="form-control" name="ServerKey" maxlength="200">
                                    </div>
                                    <div class="text-center mt-4 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Добавить</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

									<div class="mt-5 mb-3 d-block container">
										<table class="table table-striped">
											<thead>
													<tr>
															<th scope="col">Наименование</th>
															<th scope="col">Изменить</th>
													</tr>
											</thead>
											<tbody>
												<?
                        if($bots):
                        for($i = 0; $i < Count($bots); $i++):
                        ?>
													<tr>
															<td class="col-lg-6"><?=$bots[$i]['Name']?></td>
															<td class="col-lg-4"><a href="#updQuestion<?=$i?>" class="btn btn-primary" data-toggle="modal">Изменить</a></td>
													</tr>
                        <?endfor;?>
                        <?endif;?>
											</tbody>
										</table>

										<?
										if($bots):
										for($i = 0; $i < Count($bots); $i++):
										?>
											<div class="modal fade" id="updQuestion<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
															<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Редактирование бота</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
															</div>
															<div class="modal-body">
																	<form action="actions/action_bots.php?method=upd" method="post">
																			<div class="md-form mt-4" style="display: none">
                                        <label for="IdUserPanel">id</label>
                                        <input type="text" id="Id" class="form-control" name="Id" value="<?=$bots[$i]['Id']?>" maxlength="20">
																			</div>
																			<div class="md-form mt-4">
																					<label for="TestId">ID теста</label>
																					<input type="text" id="TestId" value="<?=$bots[$i]['TestId']?>"  class="form-control" name="TestId" maxlength="20">
																			</div>
																			<div class="md-form mt-4">
																					<label for="Name">Наименование (для удобства)</label>
																					<input type="text" id="Name" value="<?=$bots[$i]['Name']?>" class="form-control" name="Name" maxlength="200">
																			</div>
																			<div class="md-form mt-4">
																					<label for="Token">Токен</label>
																					<input type="text" id="Token" value="<?=$bots[$i]['Token']?>" class="form-control" name="Token" maxlength="200">
																			</div>
																			<div class="md-form mt-4">
																					<label for="ServerKey">Строка, которую должен вернуть сервер</label>
																					<input type="text" id="ServerKey" value="<?=$bots[$i]['ServerKey']?>" class="form-control" name="ServerKey" maxlength="200">
																			</div>
																			<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Сохранить</button>
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
										<?endif;?>
								</div>
				</div>
								<!-- /.row -->
			</div>
						<!-- /.container-fluid -->
		</div>
	<!-- /.content -->
</div>

    <!-- Control Sidebar -->
<? include_once '../include/control-sidebar/control-sidebar.php' ?>
<!-- /.control-sidebar -->

    <!-- Main Footer -->
<? include_once '../include/footer/footer.php' ?>
