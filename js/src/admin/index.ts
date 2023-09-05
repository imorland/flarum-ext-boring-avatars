import app from 'flarum/admin/app';
import modifyCommonAvatarHelper from '../common/modifyCommonAvatarHelper';
import modifyAdminAvatarHelper from './modifyAdminAvatarHelper';

export { default as extend } from './extend';

app.initializers.add('ianm/boring-avatars', () => {
  //modifyCommonAvatarHelper();
  //modifyAdminAvatarHelper();

  const themeOptionsArray: string[] = Array.isArray(app.data.boringAvatarThemes) ? app.data.boringAvatarThemes : [];

  // Convert the array into a key-value pair object.
  const avatarOptions: Record<string, string> = themeOptionsArray.reduce((obj, theme) => {
    obj[theme] = theme; // Use theme as both key and value.
    return obj;
  }, {});

  app.extensionData
    .for('ianm-boring-avatars')
    .registerSetting({
      setting: 'ianm-boring-avatars.theme',
      type: 'select',
      label: app.translator.trans('ianm-boring-avatars.admin.settings.theme'),
      help: app.translator.trans('ianm-boring-avatars.admin.settings.theme_help'),
      options: avatarOptions,
    })
    .registerSetting({
      setting: 'ianm-boring-avatars.include_forum_colors',
      type: 'boolean',
      label: app.translator.trans('ianm-boring-avatars.admin.settings.include_forum_colors'),
      help: app.translator.trans('ianm-boring-avatars.include_forum_colors_help'),
    });
});
