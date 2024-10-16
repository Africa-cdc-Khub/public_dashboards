<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->
<!-- Start Navigation -->
<div id="langauge-container" style="margin-bottom:-4px">
	<div class="p-3 bg-light">
		<div class="container" style="min-width: 90%;">
			<div class="row align-items-center">
				<div class="col-lg-3 col-md-3 d-none d-md-block">
					<div><a class="nav-brand" href="<?php echo base_url() ?>">
							<a class="nav-brand" href="<?php echo base_url() ?>">
								<img src="<?php echo base_url() ?>assets/images/logo.png" class="logo" alt=""
									style="height:85px;" />
							</a>
						</a>
					</div>
					<div class="mt-1 text-secondary">
						<!-- slogan -->
					</div>
				</div>
				<div class="col-lg-5 col-md-5 text-center ">
					<h3 style="color:black !important; font-weight:bold; margin-bottom: 7px;" class="notranslate">
						Africa CDC Event Dashboards
						<h3 class="slogan fw-bold" style="font-size: 14px; margin-bottom: 7px; margin-left: 20px;">
							<?=@$event?> Public Dashboards</h3>
				</div>
				<div class="col-lg-4 col-md-4 text-end d-none d-md-block justify-content-end">
					<div id="google_translate_element" style="display: none;"></div>
					<style>
						.language-menu {
							list-style-type: none;
							padding: 0;
							margin: 0;
						}

						.language-menu li {
							display: inline-block;
							margin-right: 10px;

						}
						/* Hide Google Translate banner */
						.goog-te-banner-frame.skiptranslate {
							display: none !important;
						}
						body {
							top: 0px !important;
						}
					</style>
					<div class="menu-language-menu-container">

						<ul id="menu-language-menu" class="language-menu">
							<b>Languages:</b>
							<li class="menu-item menu-item-gtranslate">
								<a href="#" onclick="doGTranslate('en'); return false;" title="English"
									class="link notranslate">English</a>
							</li>
							|
							<li class="menu-item menu-item-gtranslate">
								<a href="#" onclick="doGTranslate('fr'); return false;" title="French"
									class="link notranslate">French</a>
							</li>|
							<li class="menu-item menu-item-gtranslate">
								<a href="#" onclick="doGTranslate('ar'); return false;" title="Arabic"
									class="link notranslate">Arabic</a>
							</li>
							|
								<li class="menu-item menu-item-gtranslate">
									<a href="#" onclick="doGTranslate('es'); return false;" title="Spanish"
										class="link notranslate">Español</a>
								</li>
								|
								<li class="menu-item menu-item-gtranslate">
									<a href="#" onclick="doGTranslate('pt'); return false;" title="Portuguese"
										class="link nturl notranslate">Portuguese</a>
								</li>
								|
								<li class="menu-item menu-item-gtranslate">
									<a href="#" onclick="doGTranslate('sw'); return false;" title="Kiswahili"
										class="link nturl notranslate">Swahili</a>
								</li>
						</ul>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="header">
	<div class="container">
		<nav id="navigation" class="navigation navigation-landscape">
			<div class="nav-header">

				<div class="nav-toggle col-md-4"></div>
				<div class="mobile_nav col-md-4"  style="float:right; margin-left:20px !important;">
					<ul>
						<li>
							<a href="#" data-toggle="modal" data-target="#login" class="theme-cl fs-lg">
								<i class="lni lni-user"></i>
							</a>
						</li>

					</ul>

				</div>
			</div>
	<div class="nav-menus-wrapper" style="transition-property: none;">

				<!-- Use CSS to replace link text with flag icons -->

	<ul class="nav-menu">
                 
					<?php
					if (!empty($menus)){
					//@print_r($menus);
					foreach ($menus as $menu): ?>
						<li class="nav-item" role="presentation">
							<a class="nav-link <?= ($this->uri->segment(4) == $menu->id) ? 'active' : '' ?>" id="<?= $menu->tab ?>-tab"
								href="<?=base_url()?>records/dashboard/<?=$this->uri->segment(3)?>/<?=$menu->id?>" aria-selected="<?= ($this->uri->segment(1) == $menu->tab) ? 'true' : 'false' ?>">
								<i class="fa <?= $menu->icon ?>"></i> <?= $menu->title ?>
							</a>
						</li>
					<?php endforeach; }?>

					<ul class="nav-menu nav-menu-social align-to-right">
						<?php if (empty($this->session->userdata('user_id'))): ?>


							<li>
								<a href="#" data-toggle="modal" data-target="#login" class="ft-medium text-bold">
									<i class="lni lni-user mr-2"></i>Sign In
								</a>
							</li>

						<?php else: ?>

							<li>
								<a href="<?php echo base_url('account/logout'); ?>" class="ft-medium">
									Logout
								</a>
							</li>
						<?php endif; ?>
					</ul>




				</ul>
			</div>
	</div>
	</nav>
</div>
</div>
<!-- End Navigation -->
<div class="clearfix"></div>
<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->