import app from 'flarum/admin/app';

export { default as extend } from './extend';

app.initializers.add('ianm/boring-avatars', () => {
  const themeOptionsArray: string[] = Array.isArray(app.data.boringAvatarThemes) ? app.data.boringAvatarThemes : [];

  // Convert the array into a key-value pair object.
  const avatarOptions: Record<string, string> = themeOptionsArray.reduce((obj, theme) => {
    obj[theme] = theme; // Use theme as both key and value.
    return obj;
  }, {});

  app.extensionData
    .for('ianm-boring-avatars')
    .registerSetting({
      type: 'color-preview',
      setting: 'ianm-boring-avatars.color1',
      label: app.translator.trans('ianm-boring-avatars.admin.settings.color1'),
    })
    .registerSetting({
      type: 'color-preview',
      setting: 'ianm-boring-avatars.color2',
      label: app.translator.trans('ianm-boring-avatars.admin.settings.color2'),
    })
    .registerSetting({
      type: 'color-preview',
      setting: 'ianm-boring-avatars.color3',
      label: app.translator.trans('ianm-boring-avatars.admin.settings.color3'),
    })
    .registerSetting({
      type: 'color-preview',
      setting: 'ianm-boring-avatars.color4',
      label: app.translator.trans('ianm-boring-avatars.admin.settings.color4'),
    })
    .registerSetting({
      type: 'color-preview',
      setting: 'ianm-boring-avatars.color5',
      label: app.translator.trans('ianm-boring-avatars.admin.settings.color5'),
    })
    .registerSetting({
      setting: 'ianm-boring-avatars.theme',
      type: 'select',
      label: app.translator.trans('ianm-boring-avatars.admin.settings.theme'),
      help: app.translator.trans('ianm-boring-avatars.admin.settings.theme_help'),
      options: avatarOptions,
    });
});
