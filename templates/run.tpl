<h2>Server detail
    <small>
        <a href="/admin/<?=$key?>">back</a>
        {key: <?=$key?>}
    </small>
</h2>
<style type="text/css">
    table .small td{
        font-size:.9em;
    }
    table .small td a{
        font-size:1em;
    }
</style>

<h2>Run Detail <small>{run: <?=$qq_run_id?>}</small></h2>


<table class="ink-table ink-bordered ink-zebra">
    <thead>
        <tr>
            <th>ID</th>
            <th>time</th>
            <th>block</th>
            <th>event</th>
            <th>value</th>
            <th>id</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($Events as $e): ?>
        <tr>
            <td><?=$e->qq_run_event_id;?></td>
            <td><?=round($e->time-$Run->start_time,4)?>s</td>
            <td><?=$e->block;?></td>
            <td><?=$e->event;?></td>
            <td><?=$e->value;?></td>
            <td><?=$e->id;?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>