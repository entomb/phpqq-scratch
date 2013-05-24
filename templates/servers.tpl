
<h2>Server List</h2>

<table class="ink-table ink-zebra ink-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Key</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($servers as $item): ?>
    <tr>
        <td><?=$item->qq_server_id;?></td>
        <td><?=$item->server;?></td>
        <td><?=$item->api_key;?></td>
        <td>
            <a href="/admin/<?=$item->api_key;?>/detail" class="ink-button info">
                Details
            </a>

        </td>
    </tr>
<?php endforeach;?>
    </tbody>

</table>