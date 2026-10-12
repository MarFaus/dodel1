<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => ''.e($event->title).' — Выбор мест']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($event->title).' — Выбор мест']); ?>
    <div class="wrap" style="padding-top: 20px;">
        <a href="<?php echo e(route('events.index')); ?>" style="color: var(--mut); text-decoration: none; font-size: 13px;">← Афиша</a>
        
        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 30px; margin-top: 20px;">
            <div>
                <h1 style="font-family: var(--display); font-size: 28px; font-weight: 300;"><?php echo e($event->title); ?></h1>
                <p style="color: var(--mut); font-size: 14px; margin-bottom: 20px;"><?php echo e($event->description); ?></p>

                <div class="hall">
                    <div class="stage"><div class="stage-bar"></div><span>Сцена</span></div>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px; align-items: center;" id="seat-map">
                        <?php for ($r = 1; $r <= $hall->total_rows; $r++): ?>
                            <?php $rowSeats = $seatsByRow->get($r) ?? collect(); ?>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <span style="font-size: 11px; color: var(--dim); width: 20px; text-align: center;"><?= $r ?></span>
                                <?php foreach ($rowSeats as$seat): ?>
                                    <?php $isOccupied = in_array($seat->id,$occupiedSeatIds); ?>
                                    <button 
                                        type="button" 
                                        class="seat <?= $seat->zone === 'vip' ? 'vip' : '' ?> <?=$isOccupied ? 'taken' : '' ?>"
                                        data-seat-id="<?= $seat->id ?>"
                                        data-row="<?= $seat->row_number ?>"
                                        data-seat="<?= $seat->seat_number ?>"
                                        data-price="<?= $event->prices[$seat->zone] ?? 5000 ?>"
                                        <?= $isOccupied ? 'disabled' : '' ?>
                                    >
                                        <?= $seat->seat_number ?>
                                    </button>
                                <?php endforeach; ?>
                                <span style="font-size: 11px; color: var(--dim); width: 20px; text-align: center;"><?= $r ?></span>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div>
                <?php if (isset($component)) { $__componentOriginal36665f0dc0e45320e21db1e20a989acf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal36665f0dc0e45320e21db1e20a989acf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.panel','data' => ['title' => 'Оформление заказа']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Оформление заказа']); ?>
                    <form id="order-form" novalidate>
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="event_id" value="<?php echo e($event->id); ?>">
                        
                        <div id="form-error-box" style="display: none; padding: 10px; background: rgba(220, 53, 69, 0.15); border: 1px solid #dc3545; color: #ff8d94; border-radius: 4px; font-size: 12px; margin-bottom: 12px;"></div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">ФИО</label>
                            <input type="text" name="customer_name" id="customer_name" required placeholder="Иван Иванов" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">E-mail</label>
                            <input type="email" name="customer_email" id="customer_email" required placeholder="user@mail.kz" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Телефон</label>
                            <input type="tel" name="customer_phone" id="customer_phone" required placeholder="+7 (777) 000-00-00" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Способ оплаты</label>
                            <select name="payment_method" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                                <option value="kaspi">Kaspi Pay</option>
                                <option value="cloud">CloudPayments</option>
                                <option value="stripe">Stripe</option>
                            </select>
                        </div>

                        <div id="selected-seats-info" style="font-size: 13px; color: var(--mut); margin-bottom: 12px;">
                            Выберите места на схеме
                        </div>

                        <button type="submit" class="btn gold" style="width: 100%; opacity: 0.5; cursor: not-allowed;" id="submit-btn" disabled>
                            Оплатить <span id="total-price">0</span> ₸
                        </button>
                    </form>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal36665f0dc0e45320e21db1e20a989acf)): ?>
<?php $attributes = $__attributesOriginal36665f0dc0e45320e21db1e20a989acf; ?>
<?php unset($__attributesOriginal36665f0dc0e45320e21db1e20a989acf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal36665f0dc0e45320e21db1e20a989acf)): ?>
<?php $component = $__componentOriginal36665f0dc0e45320e21db1e20a989acf; ?>
<?php unset($__componentOriginal36665f0dc0e45320e21db1e20a989acf); ?>
<?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        const selectedSeats = new Map();

        // Блокировка ввода цифр в ФИО
        document.getElementById('customer_name').addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-Zа-яА-ЯёЁӘәҒғҚқҢңӨөҰұҮүҺһ\s\-]/g, '');
        });

        // Строгая интерактивная маска телефона +7 (XXX) XXX-XX-XX
        const phoneInput = document.getElementById('customer_phone');
        
        phoneInput.addEventListener('focus', function() {
            if (!this.value) {
                this.value = '+7 (';
            }
        });

        phoneInput.addEventListener('input', function() {
            let matrix = '+7 (___) ___-__-__';
            let i = 0;
            let def = matrix.replace(/\D/g, '');
            let val = this.value.replace(/\D/g, '');

            if (val.startsWith('8')) {
                val = '7' + val.substring(1);
            }

            if (def.length >= val.length) {
                val = def;
            }

            this.value = matrix.replace(/./g, function(a) {
                return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? '' : a;
            });
        });

        phoneInput.addEventListener('blur', function() {
            if (this.value === '+7 (' || this.value.length < 18) {
                if (this.value.length < 18) {
                    this.value = '';
                }
            }
        });

        // Клик по местам на схеме
        document.querySelectorAll('.seat:not(.taken)').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.seatId;
                if (selectedSeats.has(id)) {
                    selectedSeats.delete(id);
                    btn.classList.remove('sel');
                } else {
                    if (selectedSeats.size >= 6) return alert('Не более 6 мест!');
                    selectedSeats.set(id, {
                        row: btn.dataset.row,
                        seat: btn.dataset.seat,
                        price: parseInt(btn.dataset.price)
                    });
                    btn.classList.add('sel');
                }
                updateForm();
            });
        });

        function updateForm() {
            const info = document.getElementById('selected-seats-info');
            const totalEl = document.getElementById('total-price');
            const submitBtn = document.getElementById('submit-btn');

            if (selectedSeats.size === 0) {
                info.innerText = 'Выберите места на схеме';
                totalEl.innerText = '0';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
                submitBtn.style.cursor = 'not-allowed';
                return;
            }

            let total = 0;
            let text = [];
            selectedSeats.forEach((val) => {
                total += val.price;
                text.push(`Ряд ${val.row} м.${val.seat}`);
            });

            info.innerText = text.join(', ');
            totalEl.innerText = total.toLocaleString();
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }

        function showError(msg) {
            const errBox = document.getElementById('form-error-box');
            errBox.innerText = msg;
            errBox.style.display = 'block';
        }

        function hideError() {
            const errBox = document.getElementById('form-error-box');
            errBox.style.display = 'none';
        }

        // Отправка формы заказа
        document.getElementById('order-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            hideError();

            if (selectedSeats.size === 0) {
                showError('Пожалуйста, выберите хотя бы одно место на схеме.');
                return;
            }

            const name = document.getElementById('customer_name').value.trim();
            const email = document.getElementById('customer_email').value.trim();
            const phone = document.getElementById('customer_phone').value.trim();

            if (name.length < 2) {
                showError('Введите корректное ФИО (не менее 2 букв).');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showError('Введите корректный E-mail адрес.');
                return;
            }

            if (phone.length < 18) {
                showError('Введите полный номер телефона в формате +7 (7XX) XXX-XX-XX.');
                return;
            }

            const formData = new FormData(e.target);
            selectedSeats.forEach((_, key) => formData.append('seat_ids[]', key));

            try {
                const res = await fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    window.location.href = data.redirect;
                } else {
                    if (data.errors) {
                        const firstErr = Object.values(data.errors)[0][0];
                        showError(firstErr);
                    } else {
                        showError(data.message || 'Ошибка бронирования');
                    }
                }
            } catch (err) {
                showError('Сетевая ошибка. Попробуйте еще раз.');
            }
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?><?php /**PATH C:\Dodelivanie\sait_kards_pm03\resources\views/events/show.blade.php ENDPATH**/ ?>