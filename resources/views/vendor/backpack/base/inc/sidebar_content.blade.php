{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-question"></i> Users</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('company') }}"><i class="nav-icon la la-question"></i> Companies</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('offer') }}"><i class="nav-icon la la-question"></i> Offers</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}"><i class="nav-icon la la-question"></i> Tags</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('application') }}"><i class="nav-icon la la-question"></i> Applications</a></li>