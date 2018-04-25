<!-- START SECONDARY SIDEBAR MENU-->
<nav class="secondary-sidebar light">
    <p class="menu-title">INVENTORY</p>
    <ul class="main-menu">
        @if(strpos(request()->route()->getName(),'storage.inventory.items.general')!==false )
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{route('storage.inventory.items.general')}}">
                    <span class="title"><i class="fa fa-archive"></i> General Inventory</span>
                    {{--<span class="badge pull-right">5</span>--}}
                </a>
            </li>
        @if(strpos(request()->route()->getName(),'storage.inventory.items.testing')!==false)
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{route('storage.inventory.items.testing')}}">
                    <span class="title"><i class="fa fa-archive"></i> Testing Inventory</span>
                </a>
            </li>
        @if(strpos(request()->route()->getName(),'storage.inventory.items.company')!==false)
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{route('storage.inventory.items.company')}}">
                    <span class="title"><i class="fa fa-archive"></i> Company Inventory</span>
                </a>
            </li>
        @if(strpos(request()->route()->getName(),'storage.inventory.items.employee')!==false)
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{route('storage.inventory.items.employee')}}">
                    <span class="title"><i class="fa fa-archive"></i> Employee Inventory</span>
                </a>
            </li>
        @if(strpos(request()->route()->getName(),'storage.inventory.items.customer')!==false)
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{route('storage.inventory.items.customer')}}">
                    <span class="title"><i class="fa fa-archive"></i> Customer Inventory</span>
                </a>
            </li>
        @if(strpos(request()->route()->getName(),'storage.inventory.items.sales')!==false)
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{route('storage.inventory.items.sales')}}">
                    <span class="title"><i class="fa fa-archive"></i> Sales Inventory</span>
                </a>
            </li>
    </ul>

</nav>
<!-- END SECONDARY SIDEBAR MENU -->