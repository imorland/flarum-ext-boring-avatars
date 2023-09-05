import app from 'flarum/forum/app';
import modifyCommonAvatarHelper from '../common/modifyCommonAvatarHelper';
import modifyForumAvatarHelper from './modifyForumAvatarHelper';

export { default as extend } from './extend';

app.initializers.add('ianm/boring-avatars', () => {
  //modifyCommonAvatarHelper();
  modifyForumAvatarHelper();
});
