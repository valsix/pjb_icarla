<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

// untuk validasi kalau url tanpa param langsung tolak
// $approval_info_pg= "";
if(empty($approval_info_pg) || empty($approval_info_id))
{
    return true;
}

$this->load->library('libapproval');

$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$approval_info_id];
$vappr= new libapproval();
$datatabel= $vappr->listapproval($arrparam);
// print_r($datatabel);exit;

if(empty($datatabel))
    return true;

$appuserroleid= $this->appuserroleid;

$tabel= $approval_table;
$id= $approval_field_id;
$status= $approval_field_status;
$ref_id= $approval_info_id;

$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$approval_info_id];
$detaildok= $vappr->getdetaildok($arrparam);

$arrparam= ["ref_tabel"=>$approval_info_pg, "ref_id"=>$approval_info_id];
$datastatus= $vappr->listapprovalstatus($arrparam);
// print_r($datastatus);exit;
?>
<script type="text/javascript">
    function validapprovedata(kode)
    {
        mbox.custom({
            message: 'Anda Yakin Approve Data?',
            options: {},
            buttons: [
                {
                    label: 'Ya',
                    color: 'orange darken-2',
                    callback: function() {

                        var url= 'json-app/Approval_json/approve';
                        var isi;
                        var tabel= "<?php echo $tabel ?>";
                        var id= "<?php echo $id ?>";
                        var status= "<?php echo $status ?>";
                        var ref_id= "<?php echo $ref_id ?>";
                        var reqwaktu= timenow();

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {kode:kode,ref_id:ref_id,tabel:tabel,id:id,status:status,reqwaktu:reqwaktu},
                            success: function(data)
                            {
                                // console.log(data);return false;
                                if(data==1)
                                {
                                    isi = 'Data Berhasil Diapprove';
                                }
                                else if(data==0)
                                {
                                    isi = 'Data Gagal Diapprove';
                                }
                                else
                                {
                                    isi = data;
                                }

                                mbox.custom({
                                    message: isi,
                                    options: {}, // see Options below for options and defaults
                                    buttons: [
                                    {
                                        label: 'OK',
                                        color: 'orange darken-2',
                                        callback: function() {
                                            location.reload();
                                        }
                                    }
                                ]
                                });
                            }
                        });
                        mbox.close();

                    }
                },
                {
                    label: 'Tidak',
                    color: 'red darken-2',
                    callback: function() {
                        mbox.close();
                    }
                }
            ]
          })
    }

    function validrejectdata(kode)
    {
        mbox.custom({
            message: 'Anda Yakin Reject Data?<br/><textarea name="alasan_reject" id="alasan_reject" class="form-control"></textarea>',
            options: {},
            buttons: [
                {
                    label: 'Ya',
                    color: 'orange darken-2',
                    callback: function() {
                        alasan_reject= $("#alasan_reject").val();

                        var url= 'json-app/Approval_json/reject';
                        var isi;
                        var tabel= "<?php echo $tabel ?>";
                        var id= "<?php echo $id ?>";
                        var status= "<?php echo $status ?>";
                        var ref_id= "<?php echo $ref_id ?>";
                        var alasan= alasan_reject;
                        var reqwaktu= timenow();

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {kode:kode,ref_id:ref_id,tabel:tabel,id:id,status:status,alasan:alasan,reqwaktu:reqwaktu},
                            success: function(data)
                            {
                                // console.log(data);return false;
                                if(data==1)
                                {
                                    isi = 'Data Berhasil Direject';
                                }
                                else if(data==0)
                                {
                                    isi = 'Data Gagal Direject';
                                }
                                else
                                {
                                    isi = data;
                                }

                                mbox.custom({
                                    message: isi,
                                    options: {}, // see Options below for options and defaults
                                    buttons: [
                                    {
                                        label: 'OK',
                                        color: 'orange darken-2',
                                        callback: function() {
                                            location.reload();
                                        }
                                    }
                                ]
                                });
                            }
                        });

                        // console.log(alasan_reject);
                        $("#alasan_reject").val("");
                        mbox.close();
                    }
                },
                {
                    label: 'Tidak',
                    color: 'red darken-2',
                    callback: function() {
                        $("#alasan_reject").val("");
                        mbox.close();
                    }
                }
            ]
          })
    }

    function timenow()
    {
        var now= new Date(), ampm= 'am', h= now.getHours(), m= now.getMinutes(), s= now.getSeconds();

        if(m<10) m= '0'+m;
        if(s<10) s= '0'+s;
        return now.toLocaleDateString()+ ' ' + h + ':' + m + ':' + s;
    }
</script>

<div class="page-header">
    <h3><i class="fa fa-file-text fa-lg"></i> Approval</h3>
</div>

<?
if(!empty($detaildok))
{
    $dokinfostatus= $detaildok[0]['APPR_STATUS'];
    $dokinfostatusnama= $detaildok[0]['APPR_STATUS_NAMA'];
    // echo $dokinfostatus;

    if($dokinfostatus == "0")
    {
    ?>
        <div class="callout callout-info">
            <h4><?php echo $dokinfostatusnama?></h4>
            <p>Status menunggu approval oleh :
            <?php
            foreach ($datatabel as $key => $rows)
            {
                echo '<br> - '.$rows['ROLE_NAMA'];
            }
            ?>
            </p>
        </div>
    <?
    }
    elseif($dokinfostatus == 10 || $dokinfostatus==20)
    {
    ?>
        <div class="callout callout-success">
            <h4><?php echo $dokinfostatusnama?></h4>
            <p>Disetujui oleh :
            <?php
            foreach ($datastatus as $key => $rows)
            {
                echo '<br> - '.$rows['NAMA'].' Pada Tanggal : '.$rows['APRD_TGL'];
            }
            ?>
            </p>
        </div>
    <?
    }
    elseif($dokinfostatus == 90)
    {
    ?>
        <div class="callout callout-danger">
            <h4><?php echo $dokinfostatusnama?></h4>
            <p>Ditolak oleh :
            <?php
            foreach ($datastatus as $key => $rows)
            {
                if($rows['APRD_STATUS']==90)
                {
                    echo '<br> - '.$rows['NAMA'].' Pada Tanggal : '.$rows['APRD_TGL'];
                    echo '<br> Alasan Penolakan : ';
                    echo '<br> '.$rows['APRD_ALASANTOLAK'];
                }
            }
            ?>
            </p>
        </div>
    <?
    }
?>
<!-- <div class="callout callout-info">
    <h4>adad</h4>
    <p>Status menunggu approval oleh :
</div> -->
<?
}
else
{
?>
<div class="callout callout-warning">
    <h4>Dokumen Tidak memiliki approval / Status Draft</h4>
    <p>Harap simpan kembali dokumen (update)</p>
</div>
<?
}
?>

<table class="table table-bordered table-striped table-hovered">
    <thead>
        <th>No.</th>
        <th>Role</th>
        <th>Status</th>
        <th width='100px' nowrap>Action</th>
    </thead>
    <tbody>
    <?
    $no=0;
    $index_before = 0;
    $status_before = NULL;
    $appr_before = NULL;
    foreach ($datatabel as $key => $rows)
    {
        $vapprid= $rows['APPR_ID'];
        $vroleid= $rows['ROLE_ID'];
        $vflowdindex= $rows['FLOWD_INDEX'];

        $status= NULL;
        $infocari= $vroleid;
        $arraycari= in_array_column($infocari, "ROLE_ID", $datastatus);
        if(!empty($arraycari))
        {
            $status= $datastatus[$arraycari[0]];
        }
        // print_r($status);exit;

        // $status =  (isset($data_status[$rows['role_id']]))? $data_status[$rows['role_id']]:NULL;
        $urut = ($index_before < $vflowdindex && $index_before!=0 && $status_before == NULL)?1:0;
        $no++;
    ?>
    <tr>
        <td><?=$no?></td>
        <td><?=$rows['ROLE_NAMA']?></td>
        <td>
            <?php if($status!=NULL)
            {
                echo $status['APRD_STATUS_NAMA'].' Oleh '.$status['NAMA']. '<br>('.$status['APRD_TGL'].')';
            }
            ?>
        </td>
        <td width="200px">
             <?php
             if($appuserroleid == $vroleid && $status==NULL && $urut != 1 && $appr_before != 90)
             {
             ?>
                <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-flat" onclick="validapprovedata('<?php echo $vapprid?>')" stat="btnUpdate" data-placement="bottom" data-toggle="tooltip" data-original-title="Approve"><i class="fa fa-check"></i> Approve</a>
                <a href="javascript:void(0)" onclick="validrejectdata('<?php echo $vapprid?>')" class="btn btn-danger btn-sm btn-flat" ><i class="fa fa-times"></i> Reject</a>
            <?php
            }
            ?>
        </td>
    </tr>
    <?
    $index_before = $vflowdindex;
    $status_before = $status;
    $appr_before = $status['aprd_status'];
    }
    ?>
    </tbody>
</table>