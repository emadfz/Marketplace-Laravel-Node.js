<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Baum\Node;

class Category extends Node {

    
    protected $table = 'category';
    // 'parent_id' column name
    protected $parentColumn = 'parent_id';
    // 'lft' column name
    protected $leftColumn = 'lft';
    // 'rgt' column name
    protected $rightColumn = 'rgt';
    // 'depth' column name
    protected $depthColumn = 'depth';
    // guard attributes from mass-assignment
    protected $fillable = ['id','text', 'parent_id', 'lft', 'rgt', 'depth','category_slug','status','description','scope','product_conditions_id'];
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth','category_slug');
    
    
    public function Files() {
        return $this->morphMany('App\Models\Files', 'imageable');
    }

    public function getChildNode($parentId = '') {
        $node = $this->select('*')->where('text', 'Root category')->first();
        if (count($node->children) > 0) {
            $data = $node->getDescendantsAndSelf()->toHierarchy()->toArray();
            return $data;
        } else {
            return $node;
        }
    }
    
    public function getChildNameid($parentId = '') {
        if(is_array($parentId))
        {
            $node = $this->whereIn('id', implode(',',$parentId))->first();        
        }
        else
        {
            $node = $this->where('id', $parentId)->first();        
        }        
        return $node->children()->get()->toArray();            
    }
    
    public function getNode($id = '') {
        if (isset($id) && !empty($id) && $id != '#') {
            return $this->where('id', $id)->with('children')->first();
        }
        return $this->with('children')->first();
    }

    public function createNode($requestObject) {        
        $node = $this->where('id', $requestObject['id'])->first();        
        $child2 = $this->create(['text' => $requestObject['text'],'category_slug' => $requestObject['category_slug']]);        
        $child2->makeChildOf($node);
        return $child2;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function renameNode($requestObject) {
         
        if (isset($requestObject['id']) && !empty($requestObject['id'])) {             
            $node = $this->where('id', $requestObject['id'])->first();
            $node->text = $requestObject['text'];
            $node->category_slug = str_slug($requestObject['text'], '-');            
            return $node->save();
        } else {
            $requestObject['id'] = $requestObject['parent_id'];
            $requestObject['category_slug'] = str_slug($requestObject['text'], '-');                        
            $node = $this->createNode($requestObject);
        }
    }

    /**
     * To delete a particular selected node
     * @param selected Node Id
     * @return 
     */
    public function deleteNode($id) {
        if($id==0){
            return "fail";
        }
        $ids = $this->getChildIdsWithSelf($id);        
        if ($this->whereIn('id', $ids)->where('id', '!=', 0)->delete() > 0) {
            return "success";
        } else {
            return "fail";
        }
    }

    /**
     * To get child Ids from the parent id
     * @param Node Id
     * @return ALl child's id
     */
    public function getChildIdsWithSelf($id) {
        $node = $this->where('id', $id)->first();
        $ids = array();
        $ids = array_column($node->getDescendantsAndSelf()->toArray(), 'id');
        return $ids;
    }

    /**
     * Move node from one root to another root
     * @param NodeId - int Id, Node parent root  - int parentId, 
     * @return ALl child's id
     */
    public function moveNode($id, $parentId) {
        $node = $this->where('id', $id)->first();
        $parentNode = $this->where('id', $parentId)->first();
        $node->makeLastChildOf($parentNode);
    }

    public function copyNode($id, $parentId) {
        $node = $this->where('id', $id)->first();
        unset($node->id);
        $parentNode = $this->where('id', $parentId)->first();
        $child = $this->create($node->toArray());
        $child->makeChildOf($parentNode);
    }

    public function toggleCategoryStatus($categoryId) {
        $this->where('id', $categoryId)
                ->update(array('status' => \DB::RAW("IF(status='Active','Inactive','Active')")));
    }

    public function getNestedData() {        
        return $this->getNestedList("text", null, "&nbsp;&nbsp;&nbsp;");
    }

    public function getCategory($id) {
        return $this->where('id', $id)->first();
    }

    public function saveCategoryDetail($data, $id, $image = array()) {
        if( isset($data['product_conditions_id']) && !empty($data['product_conditions_id']) ){
            $data['product_conditions_id']=implode(',',$data['product_conditions_id']);
        }    
        
        $category = $this->where('id', $id)->first();
        $category->category_slug = str_slug($data['text'], '-');        
        $category->update($data);
        if (isset($image) && !empty($image)) {
            if ($category->Files()->get()->count() > 0) {
                $category->Files()->update($image);
            } else {
                $category->Files()->create($image);
            }
        }
        return true;
    }

    // Used for listing of Commission and Fees of categories for the scope Products & Services
    public function getCommissionFeesOfCategories($scope) {
        $data = \DB::select("SELECT "
                        . "node.id,"
                        . "CONCAT( REPEAT(IF(node.parent_id = 0, ' ', ' <span class=\"cat-commission-pad-cls\"></span> '), COUNT(parent.text) - 1), IF(node.parent_id = 0, CONCAT('<b>',node.text,'</b>'), node.text)) AS name,"
                        . "node.text AS category_name,"
                        . "node.parent_id,node.lft,node.rgt,node.commission,"
                        . "node.buy_it_now_fees,node.make_an_offer_fees,node.auction_fees,"
                        . "node.set_preview_fees,node.seller_preview_charges,node.buyer_preview_charges,node.listing_fees "
                        . "FROM category AS node, category AS parent "
                        . "WHERE "
                        . "node.lft BETWEEN parent.lft AND parent.rgt "
                        . "AND node.id != 0 "
                        . "AND node.scope = '{$scope}' "
                        . "GROUP BY node.text "
                        . "ORDER BY node.lft ASC");
        return $data;
    }

    // Get category details by id
    public function getCategoryData($id) {
        return $this->where('id', $id)->first();
    }

    // Update commission and fees of category
    public function updateCommissionFees($request, $id) {
        $data = $request->except(['_method', '_token']);
        return $this->where('id', $id)->update($data);
    }

}
