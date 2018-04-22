@if(isset(${config('maintenancemode.inject.prefix').'Enabled'}) && ${config('maintenancemode.inject.prefix').'Enabled'} == true)
    @if(config('maintenancemode.notification-styles', true))
        <style>
            .maintenance-mode-alert {
                width: 100%;
                padding: .5em;
                background-color: #FF130F;
                color: #fff;
                font-family: sans-serif;
                box-sizing: border-box;
            }
            .maintenance-mode-alert strong {
                font-weight: bold;
            }
            .maintenance-mode-alert time {
                opacity: 0.7;
                font-size: .8em;
                padding-top: .1em;
                float: right;
            }
        </style>
    @endif

    <div class="maintenance-mode-alert" id="maintenance-mode-alert" role="alert">
        <strong>{{ trans('maintenance.title') }}:</strong>

        @if(isset(${config('maintenancemode.inject.prefix').'Message'}))
            <span title="{{ ${config('maintenancemode.inject.prefix').'Message'} }}">
                {{ str_limit(${config('maintenancemode.inject.prefix').'Message'}, 100, "&hellip;") }}
            </span>
        @endif

        @if(isset(${config('maintenancemode.inject.prefix').'Timestamp'}) && ${config('maintenancemode.inject.prefix').'Timestamp'} instanceof DateTime)
            <time datetime="{{ ${config('maintenancemode.inject.prefix').'Timestamp'} }}" title="{{ ${config('maintenancemode.inject.prefix').'Timestamp'} }}">
                {{ ${config('maintenancemode.inject.prefix').'Timestamp'}->diffForHumans() }}
            </time>
        @endif
    </div>
@endif
