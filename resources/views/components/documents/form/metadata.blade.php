<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        @if (!$hideContact)
        <div class="row">
            <x-select-contact-card
                type="{{ $contactType }}"
                :contact="$contact"
                :contacts="$contacts"
                :search_route="$contactSearchRoute"
                :create_route="$contactCreateRoute"
                error="form.errors.get('contact_name')"
                :text-add-contact="$textAddContact"
                :text-create-new-contact="$textCreateNewContact"
                :text-edit-contact="$textEditContact"
                :text-contact-info="$textContactInfo"
                :text-choose-different-contact="$textChooseDifferentContact"
            />
        </div>
        @endif
    </div>

    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <div class="row">
            @if (!$hideIssuedAt)
            {{ Form::dateGroup('issued_at', trans($textIssuedAt), 'calendar', ['id' => 'issued_at', 'class' => 'form-control datepicker', 'required' => 'required', 'show-date-format' => company_date_format(), 'date-format' => 'Y-m-d', 'autocomplete' => 'off'], $issuedAt) }}
            @endif

            @if (!$hideDocumentNumber)
            {{ Form::textGroup('document_number', trans($textDocumentNumber), 'file', ['required' => 'required'], $documentNumber) }}
            @endif

            @if (!$hideDueAt)
            {{ Form::dateGroup('due_at', trans($textDueAt), 'calendar', ['id' => 'due_at', 'class' => 'form-control datepicker', 'required' => 'required', 'show-date-format' => company_date_format(), 'date-format' => 'Y-m-d', 'autocomplete' => 'off'], $dueAt) }}
            @else
            {{ Form::hidden('due_at', old('issued_at', $issuedAt), ['id' => 'due_at', 'v-model' => 'form.issued_at']) }}
            @endif

            @if (!$hideOrderNumber)
            {{ Form::textGroup('order_number', trans($textOrderNumber), 'shopping-cart', [], $orderNumber) }}
            @endif

            @if(!$hideSellTo)
            {{ Form::selectGroup('sellto', 'Vendido a', 'exchange-alt', $sellTo, null, ['required' => 'required']) }}
            @endif

            @if(!$hideMethodPayment)
            {{ Form::selectGroup('method_payment_id', 'Metodo Pago', 'exchange-alt', $methodPayment, null, ['required' => 'required']) }}
            @endif

            @if(!$hideShapePayment)
            {{ Form::selectGroup('shape_payment_id', 'Forma Pago', 'exchange-alt', $shapePayment, null, ['required' => 'required']) }}
            @endif

            @if(!$hideTypeVoucher)
            {{ Form::selectGroup('type_voucher_id', 'Tipo Comprobante', 'exchange-alt', $typeVoucher, null, ['required' => 'required']) }}
            @endif
        </div>
    </div>
</div>
