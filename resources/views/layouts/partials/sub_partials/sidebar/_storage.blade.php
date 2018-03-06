        @if(request()->route()->getPrefix()=='/storage')
        <li class="open active">
        @else
        <li class="">
        @endif
        <a href="javascript:;">
            <span class="title">Storage</span>
            @if(request()->route()->getPrefix()=='/storage')
                <span class="arrow open active"></span>
            @else
                <span class="arrow"></span>
            @endif

            </a>
            <span class="icon-thumbnail"><i data-feather="package"></i></span>
            <ul class="sub-menu">
                <li class="">
                    <a href="{{route('storage.requisition.cart')}}">Cart</a>
                    <span class="icon-thumbnail">c</span>
                </li>
                <li class="">
                    <a href="{{route('storage.requisition.shop')}}">Shop</a>
                    <span class="icon-thumbnail">r</span>
                </li>
                <li class="">
                    <a href="{{route('storage.requisition.history')}}">Track & History</a>
                    <span class="icon-thumbnail">th</span>
                </li>
                <li class="">
                    <a href="#">Stock Items</a>
                    <span class="icon-thumbnail">s</span>
                </li>
                <li>
                    <a href="javascript:;"><span class="title">Admin</span>
                        <span class="arrow"></span></a>
                    <span class="icon-thumbnail">a</span>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{route('storage.admin.approval')}}">Requisition Approval</a>
                            <span class="icon-thumbnail">ra</span>
                        </li>
                        <li>
                            <a href="javascript:;">Purchase Orders</a>
                            <span class="icon-thumbnail">po</span>
                        </li>
                        <li>
                            <a href="javascript:;">Audit</a>
                            <span class="icon-thumbnail">a</span>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;"><span class="title">Misc</span>
                        <span class="arrow"></span></a>
                    <span class="icon-thumbnail">m</span>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{route('storage.misc.items')}}">Items</a>
                            <span class="icon-thumbnail">i</span>
                        </li>
                        <li>
                            <a href="{{route('storage.misc.itemCategories')}}">Item Categories</a>
                            <span class="icon-thumbnail">ic</span>
                        </li>
                        <li>
                            <a href="{{route('storage.misc.itemTypes')}}">Item Types</a>
                            <span class="icon-thumbnail">it</span>
                        </li>
                        <li>
                            <a href="{{route('storage.misc.shipments')}}">Shipments</a>
                            <span class="icon-thumbnail">s</span>
                        </li>
                        <li>
                            <a href="{{route('storage.misc.suppliers')}}">Suppliers</a>
                            <span class="icon-thumbnail">s</span>
                        </li>
                        <li>
                            <a href="{{route('storage.misc.warehouses')}}">Warehouses</a>
                            <span class="icon-thumbnail">w</span>
                        </li>
                        <li>
                            <a href="{{route('storage.misc.units')}}">Units</a>
                            <span class="icon-thumbnail">u</span>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>