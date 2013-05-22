<h2>Server detail
    <small>{key: <?=$key?>}</small>
</h2>
<style type="text/css">
    table .small td{
        font-size:.9em;
    }
    table .small td a{
        font-size:1em;
    }
</style>



<h3>Last Runs</h3>
<table class="ink-table ink-bordered ink-zebra">
    <thead>
        <tr>
            <th>ID</th>
            <th>Root</th>
            <th>URI</th>
            <th>Date</th>
            <th>Duration</th>
            <th>Events</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody class="small">
        <?php foreach($lastRuns as $QQrun): ?>
        <tr>
            <td><?=$QQrun->run_id;?></td>
              <?php if($QQrun->isHTTP()): ?>
                <td><?=$QQrun->server('DOCUMENT_ROOT');?></td>
                <td><?=$QQrun->server('REQUEST_URI');?></td>
              <?php else: ?>
                <td><?=$QQrun->server('USER');?>@<?=$QQrun->server('SHELL');?> </td>
                <td><?=$QQrun->server('PHP_SELF');?></td>
              <?php endif ?>
            <td><?=$QQrun->str_start_time?></td>
            <td><?=$QQrun->str_duration_time?> s</td>
            <td><?=count($QQrun->_EVENT)?></td>
            <td>
                <a class="ink-button " href="/admin/<?=$key;?>/run/<?=$QQrun->run_id;?>">inspect</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>


