<x-layout-admin>

    <div id="job_main_div" class="row">
        <div class="col-12">
            <?php if($rows){
                echo '[';
                foreach($rows as $row){
                    echo '{       
                            "privilege_group_id": '.$row->privilege_group_id.',
                            "title": "'.$row->title.'",
                            "slug": "'.Str::slug($row->title).'",
                            "short_title": "'.ucfirst($row->short_title).'",
                            "order_by": '.$row->order_by.'
                        },';
                }
                echo ']';
            } ?>
        </div>
    </div>

</x-layout-admin>