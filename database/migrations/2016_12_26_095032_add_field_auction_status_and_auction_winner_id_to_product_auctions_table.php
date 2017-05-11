<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldAuctionStatusAndAuctionWinnerIdToProductAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_auctions', function (Blueprint $table) {
            $table->enum('auction_status', ['open','close'])->default('open')->after('max_product_price');           
            $table->integer('auction_winner_id')->unsigned()->index()->after('auction_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
