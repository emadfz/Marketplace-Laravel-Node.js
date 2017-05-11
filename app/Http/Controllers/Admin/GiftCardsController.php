<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\GiftCards;
use App\Models\Notifications;
use App\Models\NotificationUsers;
use App\Http\Requests\GiftCardsRequest;
use Carbon\Carbon;

class GiftCardsController extends Controller {

    public $giftCards;

    public function __construct() {
        $this->giftCards = new GiftCards();
        $this->notifications = new Notifications();        
        $this->notificationUsers = new NotificationUsers();                
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {         
        //$giftCards = GiftCards::paginate(15);
        $giftCards = $this->giftCards->getGiftCards(true);                
        //dd($giftCards);
        
        
        return view('admin.giftcards.index', compact('giftCards'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableList(Request $request) {
        return $this->giftCards->getGiftCards(true);
    }

    /**
     * Show the form for creating a Giftcards.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.giftcards.create');
        //return view('admin.giftcards.dropzone');
    }

  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GiftCardsRequest $request) {
        try{
            $data = $request->all();                        
            if ($request->ajax()) {
                $image ='';
                if ($request->hasFile('image')) {                                           
                    $image = uploadImage($request->file('image'),true);                    
                }                
                $giftCard=$this->giftCards->saveCard($data,'',$image);                
                if (!empty($giftCard)) {                    
                    //To add notifications as well as notification related users
                    $notification['text']='New Giftcard '.$giftCard['title'].' has been Added!!';                    
                    $notification['url']=URL('/admin/giftcards/'.encrypt($giftCard->id).'/edit');
                    $notification['user_id']=array(1,2,5,6);                                        
                    $notification['notifications_id']=$this->notifications->saveNotifications($notification)->id;                                        
                    $this->notificationUsers->saveNotificationUsers($notification);
                    //To add notifications as well as notification related users
                    
                    //Fire an event for run time notifications
                    \Event::fire(new \App\Events\NotificationEvent());
                    //Fire an event for run time notifications
                    
                    \Flash::success(trans('message.giftcards.add_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'giftcards.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'giftcards.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'giftcards.index');
            }
        }
        catch(\Exception $e){
            //echo $e->getMessage();die;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {        
        $giftcard = $this->giftCards->getGiftCards(false, decrypt($id));
        return view('admin.giftcards.edit', compact('giftcard', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GiftCardsRequest $request, $id) {
        try {            
            $data = $request->all();            
            
            if ($request->ajax()) {
                $image ='';
                if ($request->hasFile('image')) {                    
                    
                    if (isset($request->old_image) && !empty($request->old_image)) {
                        $image = uploadImage($request->file('image'),true,$request->old_image);
                    }
                    else{                        
                        $image = uploadImage($request->file('image'),true);
                    }

                    
                }

                unset($data['image']);
                unset($data['old_image']);                
                if ($this->giftCards->saveCard($data, decrypt($id),$image)) {
                    \Flash::success(trans('message.giftcards.update_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'giftcards.index'),
                    ]);
                } else {                       
                    \Flash::success(trans('message.failure'));                    
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'giftcards.index'),
                    ]);
                    
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'giftcards.index');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $id = decrypt($id);
            if ($this->giftCards->deleteGiftcard($id)) {
                return response()->json([
                            'status' => 'success',
                            'msg' => trans('message.giftcards.delete_success')
                ]);
            } else {
                \Flash::success(trans('message.failure'));
                return response()->json([
                            'status' => 'error',
                            'msg' => trans('message.failure')
                ]);
            }
        } catch (\Exception $e) {
            return trans('message.failure');
        }
    }

}
