import app from 'flarum/forum/app';
import { extend, override } from 'flarum/common/extend';
import AvatarEditor from 'flarum/forum/components/AvatarEditor';
import ItemList from 'flarum/common/utils/ItemList';
import type Mithril from 'mithril';

export default function modifyForumAvatarHelper() {
  extend(AvatarEditor.prototype, 'controlItems', function (items: ItemList<Mithril.Children>) {
    if (this.attrs.user.avatarIsGenerated?.()) {
      items.remove('remove');
    }
  });
}
