import app from 'flarum/forum/app';
import modifyForumAvatarHelper from './modifyForumAvatarHelper';

export { default as extend } from './extend';

app.initializers.add('ianm/boring-avatars', () => {
  modifyForumAvatarHelper();
});
