<table class="table" >
    <thead>
        <tr>
            <th>Status</th>      
            <th>Last Updated Date</th>                  
        </tr>
    </thead>
    <tbody>
        <tr>                      
            <td class="text-left"><input onchange="makeChange({{$node->id}})" type="checkbox" @if($node->status=="Active") checked @endif class="make-switch"  id="status" data-size="status"></td>      
            <td class="text-left">{{$node->updated_at}}</td>      
        </tr>    
    </tbody>
</table>



<script>
$(".make-switch").bootstrapSwitch();
</script>
                                                    
                                                    