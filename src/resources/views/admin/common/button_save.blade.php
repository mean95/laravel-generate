<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            {{ trans('core::admin.button.publish') }}
        </h3>
        <div class="card-tools">
            
        </div>
    </div>
    <div class="card-body">
        {{ Form::button(trans('core::admin.button.save'), [
                'name' => 'submit',
                'type' => 'submit', 
                'value' => 'save',
                'class' => 'uil uil-save btn btn-info btn-sm'
            ]) 
        }}
        {{ Form::button(trans('core::admin.button.save') . ' &amp; ' . trans('core::admin.button.edit'), [
                'name' => 'submit',
                'type' => 'submit', 
                'value' => 'save_edit', 
                'class' => 'uil uil-check-circle btn btn-default btn-sm'
            ]) 
        }}
    </div>
</div>