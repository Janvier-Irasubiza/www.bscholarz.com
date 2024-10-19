<div class="d-flex gap-4 mt-3">
    <a href="{{ route('md.subs-plans', ['plan' => 'Basic']) }}" 
       class="btns {{ $category == 'Basic' ? 'active-btn' : '' }}">
       Basic
    </a>

    <a href="{{ route('md.subs-plans', ['plan' => 'Standard']) }}" 
       class="btns {{ $category == 'Standard' ? 'active-btn' : '' }}">
       Standard
    </a>

    <a href="{{ route('md.subs-plans', ['plan' => 'Premium']) }}" 
       class="btns {{ $category == 'Premium' ? 'active-btn' : '' }}">
       Premium
    </a>
</div>
