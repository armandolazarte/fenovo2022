<?php

namespace App\Repositories;

use App\Models\Invoice;

class InvoicesRepository extends BaseRepository {

    public function getModel(){
        return new Invoice();
    }

    public function getByMovement($id,$pto_vta = false,$invoice_id = false){
        if($pto_vta) return $this->newQuery()->where('movement_id',$id)->where('pto_vta',$pto_vta)->first();
        if($invoice_id) return $this->newQuery()->where('movement_id',$id)->where('id',$invoice_id)->first();
        return $this->newQuery()->where('movement_id',$id)->first();
    }

    public function search($term){

        return Invoice::whereNotNull('cae')->where('voucher_number','LIKE','%'.$term.'%')->get();
    }

    public function getByVoucherNumber($voucher_number){
        return $this->newQuery()->where('voucher_number',$voucher_number)->first();
    }
}
