<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div style="border: 1px solid rgba(255,255,255,0.085); border-radius: 6px; background: #0E0E10; overflow: hidden; margin-bottom: 20px;">
    <?php if($title): ?>
        <div style="padding: 14px 18px; border-bottom: 1px solid rgba(255,255,255,0.085); font-family: 'Unbounded', sans-serif; font-size: 14px; color: #EFEDE8;">
            <?php echo e($title); ?>

        </div>
    <?php endif; ?>
    <div style="padding: 18px;">
        <?php echo e($slot); ?>

    </div>
</div><?php /**PATH C:\Dodelivanie\sait_kards_pm03\resources\views/components/panel.blade.php ENDPATH**/ ?>