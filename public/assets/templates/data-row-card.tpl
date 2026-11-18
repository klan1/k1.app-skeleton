<div class="row">
    {foreach $rows_filtered as $index => $row}
        {if isset($col_class) }
            <div class="{$col_class}">
            {else}
                <div class="col-sm-6 col-md-4 col-lg-3">
                {/if}
                <div class="card">
                    <div class="card-content">
                        <a href="{$row.user_names->get_href()}">
                            {if isset($row.user_selfie)}
                                <img src="{$row.user_selfie->get_src()}" class="card-img-top img-fluid" alt="singleminded">
                            {else}
                                <img src="{$assets_img_url}/default-person.jpg" class="card-img-top img-fluid" alt="singleminded">
                            {/if}
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{$row.user_names} {$row.user_last_names}</h5>
                            {if isset($row.user_level) }
                                <p class="card-text">
                                    <span class="badge bg-primary">{$row.user_level}</span>
                                </p>
                            {/if}
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        {if isset($row.user_login)}
                            <li class="list-group-item"><i class="text-secondary {$tc['user_login'].icon}"></i> {$row.user_login}</li>
                            {/if}
                            {if isset($row.user_phone_personal) }
                            <li class="list-group-item"><i class="text-secondary {$tc['user_phone_personal'].icon}"></i> <a href="tel:+57{$row.user_phone_personal}">{$row.user_phone_personal}</a></li>
                            {/if}
                            {if isset($row.user_phone_personal) }
                            <li class="list-group-item"><i class="text-secondary bi bi-whatsapp"></i> <a href="https://wa.me/57{$row.user_phone_personal}" target="_new">{$row.user_phone_personal}</a></li>
                            {/if}
                            {if isset($row.user_email) }
                            <li class="list-group-item"><i class="text-secondary {$tc['user_email'].icon}"></i> <a href="mailto:{$row.user_email}">{$row.user_email}</a></li>
                            {/if}
                    </ul>
                </div>
            </div>
        {foreachelse}<li>no cities found</li>{/foreach}
    </div>