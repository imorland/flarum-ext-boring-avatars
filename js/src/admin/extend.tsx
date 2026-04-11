import app from 'flarum/admin/app';
import Extend from 'flarum/common/extenders';
import Alert from 'flarum/common/components/Alert';
import LinkButton from 'flarum/common/components/LinkButton';

import commonExtend from '../common/extend';

export default [
  ...commonExtend,

  new Extend.Admin()
    .customSetting(
      () =>
        app.data.settings.avatar_driver !== 'boring-avatars' ? (
          <Alert type="warning" dismissible={false}>
            {app.translator.trans('ianm-boring-avatars.admin.settings.driver_not_active_warning')}{' '}
            <LinkButton href={app.route('basics')}>
              {app.translator.trans('ianm-boring-avatars.admin.settings.driver_not_active_warning_link')}
            </LinkButton>
          </Alert>
        ) : null,
      100
    )
    .setting(
      () => ({
        setting: 'ianm-boring-avatars.theme',
        type: 'select' as const,
        label: app.translator.trans('ianm-boring-avatars.admin.settings.theme'),
        help: app.translator.trans('ianm-boring-avatars.admin.settings.theme_help'),
        options: (Array.isArray(app.data.boringAvatarThemes) ? (app.data.boringAvatarThemes as string[]) : []).reduce(
          (obj: Record<string, string>, theme: string) => {
            obj[theme] = theme;
            return obj;
          },
          {} as Record<string, string>
        ),
      }),
      90
    )
    .setting(
      () => ({
        type: 'color-preview',
        setting: 'ianm-boring-avatars.color1',
        label: app.translator.trans('ianm-boring-avatars.admin.settings.color1'),
      }),
      80
    )
    .setting(
      () => ({
        type: 'color-preview',
        setting: 'ianm-boring-avatars.color2',
        label: app.translator.trans('ianm-boring-avatars.admin.settings.color2'),
      }),
      79
    )
    .setting(
      () => ({
        type: 'color-preview',
        setting: 'ianm-boring-avatars.color3',
        label: app.translator.trans('ianm-boring-avatars.admin.settings.color3'),
      }),
      78
    )
    .setting(
      () => ({
        type: 'color-preview',
        setting: 'ianm-boring-avatars.color4',
        label: app.translator.trans('ianm-boring-avatars.admin.settings.color4'),
      }),
      77
    )
    .setting(
      () => ({
        type: 'color-preview',
        setting: 'ianm-boring-avatars.color5',
        label: app.translator.trans('ianm-boring-avatars.admin.settings.color5'),
      }),
      76
    )
    .setting(
      () => ({
        type: 'select',
        setting: 'ianm-boring-avatars.identifier',
        label: app.translator.trans('ianm-boring-avatars.admin.settings.identifier'),
        help: app.translator.trans('ianm-boring-avatars.admin.settings.identifier_help'),
        options: {
          id: app.translator.trans('ianm-boring-avatars.admin.settings.identifier_id'),
          display_name: app.translator.trans('ianm-boring-avatars.admin.settings.identifier_display_name'),
          email: app.translator.trans('ianm-boring-avatars.admin.settings.identifier_email'),
        },
      }),
      70
    ),
];
