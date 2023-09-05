import app from 'flarum/common/app';
//import modifyAvatarHelper from './modifyAvatarHelper';

app.initializers.add('ianm/boring-avatars', () => {
  //modifyAvatarHelper();
  console.log('[ianm/test] Hello, forum and admin!');
});
