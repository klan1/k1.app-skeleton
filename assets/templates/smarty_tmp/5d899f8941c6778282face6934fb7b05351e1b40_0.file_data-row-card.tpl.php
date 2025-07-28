<?php
/* Smarty version 5.5.1, created on 2025-07-28 16:10:26
  from 'file:data-row-card.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6887a0f24cfd34_03064061',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d899f8941c6778282face6934fb7b05351e1b40' => 
    array (
      0 => 'data-row-card.tpl',
      1 => 1753510459,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6887a0f24cfd34_03064061 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/Users/j0hnd003/Develop/GitHub/server/k1.app-skeleton/assets/templates';
?><div class="row">
    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('rows_filtered'), 'row', false, 'index');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('index')->value => $_smarty_tpl->getVariable('row')->value) {
$foreach0DoElse = false;
?>
        <?php if ((true && ($_smarty_tpl->hasVariable('col_class') && null !== ($_smarty_tpl->getValue('col_class') ?? null)))) {?>
            <div class="<?php echo $_smarty_tpl->getValue('col_class');?>
">
            <?php } else { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                <?php }?>
                <div class="card">
                    <div class="card-content">
                        <a href="<?php echo $_smarty_tpl->getValue('row')['user_names']->get_href();?>
">
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('row')['user_selfie'] ?? null)))) {?>
                                <img src="<?php echo $_smarty_tpl->getValue('row')['user_selfie']->get_src();?>
" class="card-img-top img-fluid" alt="singleminded">
                            <?php } else { ?>
                                <img src="<?php echo $_smarty_tpl->getValue('assets_img_url');?>
/default-person.jpg" class="card-img-top img-fluid" alt="singleminded">
                            <?php }?>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $_smarty_tpl->getValue('row')['user_names'];?>
 <?php echo $_smarty_tpl->getValue('row')['user_last_names'];?>
</h5>
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('row')['user_level'] ?? null)))) {?>
                                <p class="card-text">
                                    <span class="badge bg-primary"><?php echo $_smarty_tpl->getValue('row')['user_level'];?>
</span>
                                </p>
                            <?php }?>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('row')['user_login'] ?? null)))) {?>
                            <li class="list-group-item"><i class="text-secondary <?php echo $_smarty_tpl->getValue('tc')['user_login']['icon'];?>
"></i> <?php echo $_smarty_tpl->getValue('row')['user_login'];?>
</li>
                            <?php }?>
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('row')['user_phone_personal'] ?? null)))) {?>
                            <li class="list-group-item"><i class="text-secondary <?php echo $_smarty_tpl->getValue('tc')['user_phone_personal']['icon'];?>
"></i> <a href="tel:+57<?php echo $_smarty_tpl->getValue('row')['user_phone_personal'];?>
"><?php echo $_smarty_tpl->getValue('row')['user_phone_personal'];?>
</a></li>
                            <?php }?>
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('row')['user_phone_personal'] ?? null)))) {?>
                            <li class="list-group-item"><i class="text-secondary bi bi-whatsapp"></i> <a href="https://wa.me/57<?php echo $_smarty_tpl->getValue('row')['user_phone_personal'];?>
" target="_new"><?php echo $_smarty_tpl->getValue('row')['user_phone_personal'];?>
</a></li>
                            <?php }?>
                            <?php if ((true && (true && null !== ($_smarty_tpl->getValue('row')['user_email'] ?? null)))) {?>
                            <li class="list-group-item"><i class="text-secondary <?php echo $_smarty_tpl->getValue('tc')['user_email']['icon'];?>
"></i> <a href="mailto:<?php echo $_smarty_tpl->getValue('row')['user_email'];?>
"><?php echo $_smarty_tpl->getValue('row')['user_email'];?>
</a></li>
                            <?php }?>
                    </ul>
                </div>
            </div>
        <?php
}
if ($foreach0DoElse) {
?><li>no cities found</li><?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </div><?php }
}
